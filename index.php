<?php
// KASARA v1.1 (Premium) - PHP murni tanpa database. Data disimpan di $_SESSION (reset saat sesi/browser ditutup).
session_start();
function rp($n){ return 'Rp ' . number_format($n, 0, ',', '.'); }
function e($s){ return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
function tok(){ return '<input type="hidden" name="t" value="' . e($_SESSION['csrf']) . '">'; }
if (empty($_SESSION['csrf'])) { $_SESSION['csrf'] = md5(uniqid(mt_rand(), true)); }

if (!isset($_SESSION['prod'])) {
  $_SESSION['prod'] = array(
    1 => array('Beras Premium 5kg', 68000, 40, 10), 2 => array('Minyak Goreng 2L', 36000, 6, 10),
    3 => array('Gula Pasir 1kg', 17000, 8, 10), 4 => array('Telur Ayam 1kg', 30000, 25, 10),
    5 => array('Kopi Sachet (10 pcs)', 10500, 4, 15), 6 => array('Mie Instan', 3500, 120, 30),
    7 => array('Susu UHT 1L', 19000, 3, 8), 8 => array('Teh Celup 25s', 8500, 30, 10),
    9 => array('Sabun Mandi', 4500, 2, 10), 10 => array('Air Mineral 600ml', 3500, 90, 24));
  $_SESSION['cust'] = array(array('Budi Santoso', '0812-1111-2222'), array('Siti Aminah', '0813-3333-4444'),
    array('Toko Maju Jaya', '0821-5555-6666'), array('Rina Wijaya', '0857-7777-8888'), array('Ahmad Fauzi', '0896-9999-0000'));
  $_SESSION['trx'] = array(
    array('INV-0045', '14:32', 'Budi Santoso', 'Jane Doe', 'QRIS', 182500, 'Lunas', null),
    array('INV-0044', '14:10', 'Umum', 'Jane Doe', 'Tunai', 64000, 'Lunas', null),
    array('INV-0043', '13:47', 'Siti Aminah', 'Rudi', 'Transfer', 245000, 'Menunggu', null),
    array('INV-0042', '13:21', 'Umum', 'Rudi', 'Tunai', 38500, 'Lunas', null),
    array('INV-0041', '12:58', 'Toko Maju Jaya', 'Jane Doe', 'QRIS', 410000, 'Lunas', null));
  $_SESSION['nama'] = 'Jane Doe'; $_SESSION['toko'] = 'Toko KASARA'; $_SESSION['no'] = 45; $_SESSION['new'] = 0; $_SESSION['newsum'] = 0;
}

// ---------- AKSI (POST) ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!isset($_POST['t']) || $_POST['t'] !== $_SESSION['csrf']) { die('Token tidak valid.'); }
  $a = isset($_POST['a']) ? $_POST['a'] : ''; $go = '?p=beranda'; $msg = '';
  if ($a === 'checkout') {
    $cart = json_decode(isset($_POST['cart']) ? $_POST['cart'] : '[]', true);
    $items = array(); $total = 0; $ok = is_array($cart) && count($cart) > 0;
    if ($ok) { foreach ($cart as $id => $q) {
      $id = (int)$id; $q = (int)$q;
      if (!isset($_SESSION['prod'][$id]) || $q < 1 || $q > $_SESSION['prod'][$id][2]) { $ok = false; break; }
      $items[] = array($_SESSION['prod'][$id][0], $q, $_SESSION['prod'][$id][1]); $total += $q * $_SESSION['prod'][$id][1];
    } }
    if (!$ok) { $msg = 'Keranjang kosong atau stok tidak cukup.'; $go = '?p=kasir'; }
    else {
      foreach ($cart as $id => $q) { $_SESSION['prod'][(int)$id][2] -= (int)$q; }
      $_SESSION['no']++; $inv = 'INV-' . str_pad($_SESSION['no'], 4, '0', STR_PAD_LEFT);
      $pel = isset($_POST['pel']) && $_POST['pel'] !== '' ? substr($_POST['pel'], 0, 60) : 'Umum';
      $m = in_array($_POST['metode'], array('Tunai', 'QRIS', 'Transfer')) ? $_POST['metode'] : 'Tunai';
      array_unshift($_SESSION['trx'], array($inv, date('H:i'), $pel, $_SESSION['nama'], $m, $total, 'Lunas', $items));
      $_SESSION['new']++; $_SESSION['newsum'] += $total; $go = '?p=struk&id=' . $inv; $msg = 'Transaksi ' . $inv . ' berhasil disimpan.';
    }
  } elseif ($a === 'stok') {
    $id = (int)$_POST['id']; $j = (int)$_POST['jumlah'];
    if (isset($_SESSION['prod'][$id]) && $j > 0 && $j <= 100000) { $_SESSION['prod'][$id][2] += $j; $msg = 'Stok ' . $_SESSION['prod'][$id][0] . ' bertambah ' . $j . '.'; }
    else { $msg = 'Data stok tidak valid.'; }
    $go = '?p=produk';
  } elseif ($a === 'produk') {
    $n = trim($_POST['nama']); $h = (int)$_POST['harga']; $s = (int)$_POST['stok'];
    if ($n !== '' && $h > 0 && $s >= 0) { $_SESSION['prod'][max(array_keys($_SESSION['prod'])) + 1] = array(substr($n, 0, 60), $h, $s, 10); $msg = 'Produk ditambahkan.'; }
    else { $msg = 'Isi nama, harga, dan stok dengan benar.'; }
    $go = '?p=produk';
  } elseif ($a === 'pelanggan') {
    $n = trim($_POST['nama']);
    if ($n !== '') { $_SESSION['cust'][] = array(substr($n, 0, 60), substr(trim($_POST['hp']), 0, 20)); $msg = 'Pelanggan ditambahkan.'; }
    else { $msg = 'Nama wajib diisi.'; }
    $go = '?p=pelanggan';
  } elseif ($a === 'setting') {
    if (trim($_POST['nama']) !== '') { $_SESSION['nama'] = substr(trim($_POST['nama']), 0, 40); }
    if (trim($_POST['toko']) !== '') { $_SESSION['toko'] = substr(trim($_POST['toko']), 0, 40); }
    $msg = 'Pengaturan disimpan.'; $go = '?p=pengaturan';
  } elseif ($a === 'reset') { session_destroy(); header('Location: index.php'); exit; }
  $_SESSION['flash'] = $msg; header('Location: ' . $go); exit;
}

// ---------- DATA TURUNAN ----------
$p = isset($_GET['p']) ? $_GET['p'] : 'beranda';
if (!in_array($p, array('beranda', 'kasir', 'produk', 'pelanggan', 'laporan', 'pengaturan', 'panduan', 'struk'))) { $p = 'beranda'; }
$flash = isset($_SESSION['flash']) ? $_SESSION['flash'] : ''; unset($_SESSION['flash']);
$rendah = 0; foreach ($_SESSION['prod'] as $pr) { if ($pr[2] <= $pr[3]) { $rendah++; } }
$omset = 3850000 + $_SESSION['newsum']; $trxN = 45 + $_SESSION['new']; $laba = round($omset * 0.3);
$kemarin = 3437500; $naik = round(($omset - $kemarin) / $kemarin * 100);
$chart = array(
  'minggu' => array('label' => array('Kam', 'Jum', 'Sab', 'Min', 'Sen', 'Sel', 'Rab'),
    'omset' => array(3120000, 3480000, 4210000, 4560000, 3290000, 3437500, $omset), 'laba' => array(936000, 1044000, 1263000, 1368000, 987000, 1031250, $laba)),
  'bulan' => array('label' => array('Mg 1', 'Mg 2', 'Mg 3', 'Mg 4'), 'omset' => array(22400000, 24100000, 23300000, 26800000), 'laba' => array(6720000, 7230000, 6990000, 8040000)),
  'tahun' => array('label' => array('Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov'),
    'omset' => array(81e6, 76e6, 88e6, 92e6, 95e6, 90e6, 99e6, 103e6, 98e6, 107e6, 52e6), 'laba' => array(24.3e6, 22.8e6, 26.4e6, 27.6e6, 28.5e6, 27e6, 29.7e6, 30.9e6, 29.4e6, 32.1e6, 15.6e6)));
$terlaris = array(array('Beras Premium 5kg', 62, 7210000), array('Telur Ayam 1kg', 71, 2130000), array('Minyak Goreng 2L', 48, 1450000), array('Gula Pasir 1kg', 95, 1330000), array('Kopi Sachet (10 pcs)', 120, 1260000));
$loyal = array(array('Budi Santoso', 8, 1240000), array('Siti Aminah', 6, 985000), array('Toko Maju Jaya', 4, 870000), array('Rina Wijaya', 5, 640000), array('Ahmad Fauzi', 3, 515000));
$sumT = 0; foreach ($terlaris as $x) { $sumT += $x[2]; }
$menu = array('beranda' => '&#128202; Beranda', 'kasir' => '&#128179; Kasir Baru', 'produk' => '&#128230; Produk &amp; Stok', 'pelanggan' => '&#128101; Pelanggan', 'laporan' => '&#128200; Laporan', 'pengaturan' => '&#9881;&#65039; Pengaturan');
$s = isset($_GET['s']) ? $_GET['s'] : 'penjualan';
?><!DOCTYPE html>
<html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>KASARA - <?= e(ucfirst($p)) ?></title>
<style>
:root{--bg:#0b1118;--panel:#121b26;--line:#1f2d3d;--txt:#e6edf5;--mut:#8a9bb0;--cy:#22d3ee;--or:#fb923c;--rd:#ef4444;--gr:#34d399}
*{box-sizing:border-box;margin:0}body{font-family:system-ui,-apple-system,"Segoe UI",Roboto,sans-serif;background:var(--bg);color:var(--txt);min-height:100vh}
a{color:inherit;text-decoration:none}:focus-visible{outline:2px solid var(--cy);outline-offset:2px}
.top{position:sticky;top:0;z-index:20;display:flex;justify-content:space-between;align-items:center;padding:12px 20px;background:rgba(11,17,24,.95);border-bottom:1px solid var(--line)}
.logo{display:flex;align-items:center;gap:10px;font-weight:800;letter-spacing:.2em}.logo small{font-weight:500;letter-spacing:0;color:var(--mut);font-size:12px;border:1px solid var(--line);padding:2px 8px;border-radius:99px}
.right{display:flex;align-items:center;gap:16px}.bell{position:relative;font-size:20px}.bell b{position:absolute;top:-8px;right:-10px;background:var(--rd);font-size:11px;border-radius:99px;padding:1px 6px}
.me{font-size:14px;color:var(--mut)}.me strong{color:var(--txt)}
.wrap{display:grid;grid-template-columns:230px 1fr}
.side{padding:16px 12px;border-right:1px solid var(--line);min-height:calc(100vh - 57px)}
.side a{display:block;padding:10px 12px;border-radius:10px;color:var(--mut);margin-bottom:4px}.side a:hover{background:var(--panel);color:var(--txt)}
.side a.on{background:rgba(34,211,238,.12);color:var(--cy);font-weight:600}
.side a.kasir{background:linear-gradient(90deg,var(--cy),#0ea5c4);color:#04222a;font-weight:700;margin:10px 0;text-align:center;box-shadow:0 0 18px rgba(34,211,238,.35)}
.side a.sub{margin-left:26px;font-size:13px;padding:6px 12px}
main{padding:20px;max-width:1200px;width:100%}h1{font-size:20px;margin-bottom:16px}
.flash{background:rgba(34,211,238,.12);border:1px solid var(--cy);color:var(--cy);padding:10px 14px;border-radius:10px;margin-bottom:14px}
.cards{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:18px}
.card{display:block;background:var(--panel);border:1px solid var(--line);border-radius:14px;padding:16px;border-top:3px solid var(--c)}
a.card:hover{border-color:var(--c)}.card span{font-size:13px;color:var(--mut)}.card h2{font-size:22px;margin:6px 0}.card p{font-size:13px;color:var(--mut)}
.cy{--c:var(--cy)}.or{--c:var(--or)}.rd{--c:var(--rd)}.up{color:var(--gr)}
.grid{display:grid;grid-template-columns:3fr 2fr;gap:14px;margin-bottom:18px}
.box{background:var(--panel);border:1px solid var(--line);border-radius:14px;padding:16px;margin-bottom:14px}
.head{display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px;margin-bottom:12px}.head h3{font-size:16px}
.tabs button,.tabs a{display:inline-block;background:none;border:1px solid var(--line);color:var(--mut);padding:5px 12px;border-radius:99px;cursor:pointer;font-size:13px;margin-left:4px}
.tabs .on{background:var(--cy);color:#04222a;border-color:var(--cy);font-weight:600}
.leg{font-size:12px;color:var(--mut);margin-top:6px}.leg i{display:inline-block;width:10px;height:10px;border-radius:50%;margin:0 4px 0 10px}svg{width:100%;height:auto;display:block}
ol{list-style:none;padding:0}ol li{display:flex;justify-content:space-between;gap:10px;padding:10px 0;border-bottom:1px solid var(--line);font-size:14px}
ol li small{display:block;color:var(--mut)}ol li em{font-style:normal;color:var(--cy);font-weight:600;text-align:right}.hide{display:none}
.tw{overflow-x:auto}table{width:100%;border-collapse:collapse;font-size:14px;min-width:560px}th,td{text-align:left;padding:10px 8px;border-bottom:1px solid var(--line);white-space:nowrap}th{color:var(--mut);font-weight:500;font-size:13px}
.st{padding:2px 10px;border-radius:99px;font-size:12px}.Lunas,.Aman{background:rgba(52,211,153,.15);color:var(--gr)}.Menunggu{background:rgba(251,146,60,.15);color:var(--or)}.Rendah{background:rgba(239,68,68,.15);color:var(--rd)}
.btn{display:inline-block;background:none;border:1px solid var(--or);color:var(--or);padding:7px 14px;border-radius:8px;cursor:pointer;font-size:14px}.btn:hover{background:var(--or);color:#2a1300}
.btn.pri{background:var(--cy);border-color:var(--cy);color:#04222a;font-weight:700}
input,select{background:#0b1118;border:1px solid var(--line);color:var(--txt);padding:9px 10px;border-radius:8px;font-size:14px;max-width:100%}
.frm{display:flex;flex-wrap:wrap;gap:8px;align-items:center}
.pgrid{display:grid;grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:10px}
.pbtn{background:#0b1118;border:1px solid var(--line);color:var(--txt);padding:12px;border-radius:10px;text-align:left;cursor:pointer}.pbtn:hover{border-color:var(--cy)}.pbtn small{display:block;color:var(--mut);margin-top:4px}.pbtn:disabled{opacity:.4;cursor:not-allowed}
.k2{display:grid;grid-template-columns:2fr 1fr;gap:14px}
.fab{position:fixed;right:18px;bottom:18px;display:flex;flex-direction:column;gap:8px;z-index:30}
.fab a{background:var(--panel);border:1px solid var(--cy);color:var(--cy);padding:10px 16px;border-radius:99px;font-size:14px;box-shadow:0 4px 18px rgba(0,0,0,.5)}.fab a:hover{background:var(--cy);color:#04222a}
.struk{max-width:380px;margin:0 auto;font-family:monospace}.struk hr{border:0;border-top:1px dashed var(--mut);margin:10px 0}.struk div{display:flex;justify-content:space-between;gap:8px;font-size:14px;padding:2px 0}
@media print{.top,.side,.fab,.noprint{display:none!important}body{background:#fff;color:#000}.box{border:0;background:#fff}}
@media(max-width:960px){.wrap{grid-template-columns:1fr}.side{display:flex;overflow-x:auto;gap:4px;border-right:0;border-bottom:1px solid var(--line);min-height:0}.side a{white-space:nowrap;margin:0}.side a.sub{display:none}.cards{grid-template-columns:repeat(2,1fr)}.grid,.k2{grid-template-columns:1fr}.me{display:none}}
</style></head><body>
<header class="top">
  <a class="logo" href="?p=beranda"><svg width="28" height="28" viewBox="0 0 28 28" fill="none" stroke="#22d3ee" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 22c8 0 14-4 17-13"/><path d="M14 8h8v8"/></svg>KASARA <small>v1.1 (Premium)</small></a>
  <div class="right"><a class="bell" href="?p=produk&amp;f=rendah" title="Stok rendah" aria-label="<?= $rendah ?> stok rendah">&#128276;<?php if ($rendah) { ?><b><?= $rendah ?></b><?php } ?></a>
  <div class="me"><strong>Admin</strong> - <?= e($_SESSION['nama']) ?></div></div>
</header>
<div class="wrap">
<nav class="side" aria-label="Menu utama">
<?php foreach ($menu as $k => $lbl) { $cls = ($k === $p || ($k === 'beranda' && $p === 'struk')) ? 'on' : ''; if ($k === 'kasir') { $cls .= ' kasir'; } ?>
  <a href="?p=<?= $k ?><?= $k === 'laporan' ? '&amp;s=penjualan' : '' ?>" class="<?= $cls ?>"><?= $lbl ?></a>
  <?php if ($k === 'laporan') { foreach (array('penjualan' => 'Penjualan', 'laba' => 'Laba', 'pajak' => 'Pajak') as $sk => $sl) { ?><a class="sub" href="?p=laporan&amp;s=<?= $sk ?>"><?= $sl ?></a><?php } } ?>
<?php } ?>
</nav>
<main>
<?php if ($flash !== '') { ?><div class="flash" role="status"><?= e($flash) ?></div><?php } ?>

<?php if ($p === 'beranda') { ?>
<h1>Ringkasan Kinerja Hari Ini</h1>
<section class="cards">
  <div class="card cy"><span>Omset Hari Ini</span><h2><?= rp($omset) ?></h2><p><b class="up">+<?= $naik ?>%</b> vs kemarin</p></div>
  <a class="card cy" href="?p=laporan&amp;s=penjualan"><span>Total Transaksi</span><h2><?= $trxN ?></h2><p>Rata-rata keranjang: <?= rp(round($omset / $trxN, -2)) ?></p></a>
  <a class="card or" href="?p=laporan&amp;s=laba"><span>Estimasi Laba Kotor</span><h2><?= rp($laba) ?></h2><p>Margin 30%</p></a>
  <a class="card rd" href="?p=produk&amp;f=rendah"><span>Peringatan Stok</span><h2><?= $rendah ?> Produk</h2><p>Hampir habis - klik untuk melihat</p></a>
</section>
<section class="grid">
  <div class="box"><div class="head"><h3 id="ctitle">Kinerja Penjualan Minggu Ini</h3>
    <div class="tabs" id="range"><button class="on" data-r="minggu">Minggu Ini</button><button data-r="bulan">Bulan Ini</button><button data-r="tahun">Tahun Ini</button></div></div>
    <svg id="svg" viewBox="0 0 600 260" role="img" aria-label="Grafik omset dan laba"></svg>
    <div class="leg"><i style="background:var(--cy)"></i>Omset<i style="background:var(--or)"></i>Laba</div></div>
  <div class="box"><div class="head"><h3>Rangkuman Mingguan</h3>
    <div class="tabs" id="sum"><button class="on" data-t="p">Produk Terlaris</button><button data-t="c">Pelanggan Loyal</button></div></div>
    <ol id="lp"><?php foreach ($terlaris as $i => $x) { ?><li><span><?= $i + 1 ?>. <?= e($x[0]) ?><small><?= $x[1] ?> terjual</small></span><em><?= rp($x[2]) ?><small><?= round($x[2] / $sumT * 100) ?>% omset</small></em></li><?php } ?></ol>
    <ol id="lc" class="hide"><?php foreach ($loyal as $i => $x) { ?><li><span><?= $i + 1 ?>. <?= e($x[0]) ?><small><?= $x[1] ?> transaksi</small></span><em><?= rp($x[2]) ?></em></li><?php } ?></ol></div>
</section>
<section class="box"><div class="head"><h3>Daftar Transaksi Kasir (5 Terakhir)</h3><a class="btn" href="?p=struk&amp;id=<?= e($_SESSION['trx'][0][0]) ?>">&#128424; Cetak Ulang Struk Terakhir</a></div>
  <div class="tw"><table><thead><tr><th>ID Struk</th><th>Waktu</th><th>Pelanggan</th><th>Kasir</th><th>Metode Bayar</th><th>Total</th><th>Status</th></tr></thead><tbody>
  <?php foreach (array_slice($_SESSION['trx'], 0, 5) as $t) { ?><tr><td><a href="?p=struk&amp;id=<?= e($t[0]) ?>" style="color:var(--cy)"><?= e($t[0]) ?></a></td><td><?= e($t[1]) ?></td><td><?= e($t[2]) ?></td><td><?= e($t[3]) ?></td><td><?= e($t[4]) ?></td><td><?= rp($t[5]) ?></td><td><span class="st <?= e($t[6]) ?>"><?= e($t[6]) ?></span></td></tr><?php } ?>
  </tbody></table></div></section>

<?php } elseif ($p === 'kasir') { ?>
<h1>Kasir Baru</h1>
<div class="k2">
  <div class="box"><div class="head"><h3>Pilih Produk</h3><input id="cari" placeholder="Cari produk..." aria-label="Cari produk"></div>
    <div class="pgrid" id="pg"></div></div>
  <form class="box" method="post" id="fk"><div class="head"><h3>Keranjang</h3></div>
    <ol id="cartl"></ol><p id="kosong" style="color:var(--mut);font-size:14px">Belum ada item.</p>
    <div class="head" style="margin-top:12px"><strong>Total</strong><strong id="tot" style="color:var(--cy)">Rp 0</strong></div>
    <div class="frm" style="flex-direction:column;align-items:stretch">
      <select name="pel" aria-label="Pelanggan"><option value="">Umum</option><?php foreach ($_SESSION['cust'] as $c) { ?><option><?= e($c[0]) ?></option><?php } ?></select>
      <select name="metode" aria-label="Metode bayar"><option>Tunai</option><option>QRIS</option><option>Transfer</option></select>
      <?= tok() ?><input type="hidden" name="a" value="checkout"><input type="hidden" name="cart" id="cartin">
      <button class="btn pri" type="submit">Bayar &amp; Cetak Struk</button></div></form>
</div>

<?php } elseif ($p === 'produk') { $f = isset($_GET['f']) ? $_GET['f'] : ''; ?>
<h1>Produk &amp; Stok</h1>
<div class="box" id="stokcepat"><div class="head"><h3>Tambah Stok Cepat</h3></div>
  <form class="frm" method="post"><?= tok() ?><input type="hidden" name="a" value="stok">
  <select name="id" aria-label="Produk"><?php foreach ($_SESSION['prod'] as $id => $pr) { ?><option value="<?= $id ?>"><?= e($pr[0]) ?> (stok <?= $pr[2] ?>)</option><?php } ?></select>
  <input type="number" name="jumlah" min="1" value="10" required aria-label="Jumlah"><button class="btn pri">Tambah</button></form></div>
<div class="box"><div class="head"><h3>Daftar Produk</h3><div class="tabs"><a href="?p=produk" class="<?= $f === '' ? 'on' : '' ?>">Semua</a><a href="?p=produk&amp;f=rendah" class="<?= $f === 'rendah' ? 'on' : '' ?>">Stok Rendah</a></div></div>
  <div class="tw"><table><thead><tr><th>Produk</th><th>Harga</th><th>Stok</th><th>Status</th></tr></thead><tbody>
  <?php foreach ($_SESSION['prod'] as $pr) { $low = $pr[2] <= $pr[3]; if ($f === 'rendah' && !$low) { continue; } ?><tr><td><?= e($pr[0]) ?></td><td><?= rp($pr[1]) ?></td><td><?= $pr[2] ?></td><td><span class="st <?= $low ? 'Rendah' : 'Aman' ?>"><?= $low ? 'Rendah' : 'Aman' ?></span></td></tr><?php } ?>
  </tbody></table></div></div>
<div class="box"><div class="head"><h3>Produk Baru</h3></div>
  <form class="frm" method="post"><?= tok() ?><input type="hidden" name="a" value="produk"><input name="nama" placeholder="Nama produk" required><input type="number" name="harga" min="1" placeholder="Harga" required><input type="number" name="stok" min="0" placeholder="Stok awal" required><button class="btn pri">Simpan</button></form></div>

<?php } elseif ($p === 'pelanggan') { ?>
<h1>Pelanggan</h1>
<div class="box" id="tambah"><div class="head"><h3>Tambah Pelanggan</h3></div>
  <form class="frm" method="post"><?= tok() ?><input type="hidden" name="a" value="pelanggan"><input name="nama" placeholder="Nama pelanggan" required><input name="hp" placeholder="No. HP"><button class="btn pri">Simpan</button></form></div>
<div class="box"><div class="tw"><table><thead><tr><th>#</th><th>Nama</th><th>No. HP</th></tr></thead><tbody>
  <?php foreach ($_SESSION['cust'] as $i => $c) { ?><tr><td><?= $i + 1 ?></td><td><?= e($c[0]) ?></td><td><?= e($c[1]) ?></td></tr><?php } ?></tbody></table></div></div>

<?php } elseif ($p === 'laporan') { ?>
<h1>Laporan</h1>
<div class="tabs" style="margin-bottom:14px"><?php foreach (array('penjualan' => 'Penjualan', 'laba' => 'Laba', 'pajak' => 'Pajak') as $k => $l) { ?><a href="?p=laporan&amp;s=<?= $k ?>" class="<?= $s === $k ? 'on' : '' ?>"><?= $l ?></a><?php } ?></div>
<div class="box"><div class="tw"><table>
<?php if ($s === 'laba') { ?><thead><tr><th>Hari</th><th>Omset</th><th>Laba</th><th>Margin</th></tr></thead><tbody>
  <?php foreach ($chart['minggu']['label'] as $i => $l) { $o = $chart['minggu']['omset'][$i]; $b = $chart['minggu']['laba'][$i]; ?><tr><td><?= $l ?></td><td><?= rp($o) ?></td><td><?= rp($b) ?></td><td><?= round($b / $o * 100) ?>%</td></tr><?php } ?></tbody>
<?php } elseif ($s === 'pajak') { $tot = array_sum($chart['minggu']['omset']); $ppn = round($tot * 11 / 111); ?><thead><tr><th>Keterangan</th><th>Nilai</th></tr></thead><tbody>
  <tr><td>Omset 7 hari (termasuk PPN)</td><td><?= rp($tot) ?></td></tr><tr><td>Estimasi PPN 11% (sudah termasuk harga)</td><td><?= rp($ppn) ?></td></tr><tr><td>Omset sebelum PPN</td><td><?= rp($tot - $ppn) ?></td></tr></tbody>
<?php } else { ?><thead><tr><th>ID Struk</th><th>Waktu</th><th>Pelanggan</th><th>Kasir</th><th>Metode</th><th>Total</th></tr></thead><tbody>
  <?php foreach ($_SESSION['trx'] as $t) { ?><tr><td><a href="?p=struk&amp;id=<?= e($t[0]) ?>" style="color:var(--cy)"><?= e($t[0]) ?></a></td><td><?= e($t[1]) ?></td><td><?= e($t[2]) ?></td><td><?= e($t[3]) ?></td><td><?= e($t[4]) ?></td><td><?= rp($t[5]) ?></td></tr><?php } ?></tbody>
<?php } ?></table></div></div>

<?php } elseif ($p === 'pengaturan') { ?>
<h1>Pengaturan</h1>
<div class="box"><form class="frm" method="post"><?= tok() ?><input type="hidden" name="a" value="setting"><input name="nama" value="<?= e($_SESSION['nama']) ?>" aria-label="Nama admin"><input name="toko" value="<?= e($_SESSION['toko']) ?>" aria-label="Nama toko"><button class="btn pri">Simpan</button></form></div>
<div class="box"><p style="color:var(--mut);margin-bottom:10px">Kembalikan semua data contoh (stok, transaksi, pelanggan) ke kondisi awal.</p>
  <form method="post" onsubmit="return confirm('Reset semua data contoh?')"><?= tok() ?><input type="hidden" name="a" value="reset"><button class="btn">Reset Data Contoh</button></form></div>

<?php } elseif ($p === 'panduan') { ?>
<h1>Buku Panduan</h1>
<div class="box"><ol>
  <li><span>1. Kasir Baru<small>Klik produk untuk menambah ke keranjang, atur jumlah, pilih pelanggan dan metode bayar, lalu Bayar.</small></span></li>
  <li><span>2. Produk &amp; Stok<small>Tambah stok cepat, tambah produk baru, dan lihat produk yang stoknya rendah.</small></span></li>
  <li><span>3. Pelanggan<small>Simpan data pelanggan agar bisa dipilih saat transaksi.</small></span></li>
  <li><span>4. Laporan<small>Penjualan, laba, dan estimasi pajak.</small></span></li>
  <li><span>5. Cetak Ulang<small>Klik ID Struk atau tombol Cetak Ulang di Beranda, lalu tekan Cetak.</small></span></li></ol></div>

<?php } elseif ($p === 'struk') { $found = null; foreach ($_SESSION['trx'] as $t) { if (isset($_GET['id']) && $t[0] === $_GET['id']) { $found = $t; } } ?>
<h1 class="noprint">Struk</h1>
<?php if (!$found) { ?><div class="box">Struk tidak ditemukan.</div><?php } else { ?>
<div class="box struk"><div style="justify-content:center"><strong><?= e($_SESSION['toko']) ?></strong></div><hr>
  <div><span><?= e($found[0]) ?></span><span><?= e($found[1]) ?></span></div><div><span>Pelanggan</span><span><?= e($found[2]) ?></span></div><div><span>Kasir</span><span><?= e($found[3]) ?></span></div><hr>
  <?php if ($found[7]) { foreach ($found[7] as $it) { ?><div><span><?= e($it[0]) ?> x<?= $it[1] ?></span><span><?= rp($it[1] * $it[2]) ?></span></div><?php } } else { ?><div><span>(Rincian item tidak tersedia untuk data contoh)</span></div><?php } ?>
  <hr><div><strong>Total</strong><strong><?= rp($found[5]) ?></strong></div><div><span>Bayar</span><span><?= e($found[4]) ?></span></div><hr><div style="justify-content:center">Terima kasih</div></div>
<p class="noprint"><button class="btn pri" onclick="window.print()">&#128424; Cetak</button> <a class="btn" href="?p=beranda">Kembali</a></p>
<?php } } ?>
</main></div>

<div class="fab noprint" aria-label="Akses cepat">
  <a href="?p=produk#stokcepat">[+] Tambah Stok Cepat</a><a href="?p=pelanggan#tambah">[+] Tambah Pelanggan</a><a href="?p=panduan">[?] Buka Buku Panduan</a>
</div>

<script>
<?php if ($p === 'beranda') { ?>
var DATA = <?= json_encode($chart) ?>, TITLE = {minggu:'Minggu Ini', bulan:'Bulan Ini', tahun:'Tahun Ini'};
function draw(key){
  var d = DATA[key], W = 600, H = 260, L = 52, R = 14, T = 14, B = 28, max = Math.max.apply(null, d.omset) * 1.1 || 1, n = d.label.length, s = '';
  var x = function(i){ return L + (n === 1 ? 0 : i * (W - L - R) / (n - 1)); }, y = function(v){ return T + (H - T - B) * (1 - v / max); };
  for (var g = 0; g <= 4; g++){ var gv = max * g / 4, gy = y(gv);
    s += '<line x1="'+L+'" x2="'+(W-R)+'" y1="'+gy+'" y2="'+gy+'" stroke="#1f2d3d"/><text x="'+(L-6)+'" y="'+(gy+4)+'" fill="#8a9bb0" font-size="10" text-anchor="end">'+(gv>=1e6?(gv/1e6).toFixed(1)+' jt':Math.round(gv/1e3)+' rb')+'</text>'; }
  d.label.forEach(function(l,i){ s += '<text x="'+x(i)+'" y="'+(H-8)+'" fill="#8a9bb0" font-size="11" text-anchor="middle">'+l+'</text>'; });
  [['omset','#22d3ee'],['laba','#fb923c']].forEach(function(k){
    s += '<polyline fill="none" stroke="'+k[1]+'" stroke-width="2.5" stroke-linejoin="round" points="'+d[k[0]].map(function(v,i){ return x(i)+','+y(v); }).join(' ')+'"/>';
    d[k[0]].forEach(function(v,i){ s += '<circle cx="'+x(i)+'" cy="'+y(v)+'" r="4" fill="'+k[1]+'"><title>'+d.label[i]+' - '+k[0]+': Rp '+Math.round(v).toLocaleString('id-ID')+'</title></circle>'; }); });
  document.getElementById('svg').innerHTML = s; document.getElementById('ctitle').textContent = 'Kinerja Penjualan ' + TITLE[key];
}
function tabs(id, fn){ var bs = document.querySelectorAll('#'+id+' button'); bs.forEach(function(b){ b.onclick = function(){ bs.forEach(function(o){ o.classList.remove('on'); }); b.classList.add('on'); fn(b); }; }); }
tabs('range', function(b){ draw(b.dataset.r); });
tabs('sum', function(b){ document.getElementById('lp').classList.toggle('hide', b.dataset.t !== 'p'); document.getElementById('lc').classList.toggle('hide', b.dataset.t !== 'c'); });
draw('minggu');
<?php } elseif ($p === 'kasir') { ?>
var PROD = <?= json_encode($_SESSION['prod']) ?>, cart = {};
function rp(n){ return 'Rp ' + n.toLocaleString('id-ID'); }
function esc(t){ var d = document.createElement('div'); d.textContent = t; return d.innerHTML; }
function grid(){ var q = document.getElementById('cari').value.toLowerCase(), h = '';
  for (var id in PROD){ var p = PROD[id]; if (p[0].toLowerCase().indexOf(q) < 0) continue;
    h += '<button type="button" class="pbtn" data-id="'+id+'"'+(p[2] < 1 ? ' disabled' : '')+'>'+esc(p[0])+'<small>'+rp(p[1])+' - stok '+p[2]+'</small></button>'; }
  document.getElementById('pg').innerHTML = h || '<p style="color:var(--mut)">Tidak ada produk.</p>'; }
function render(){ var h = '', t = 0, c = 0;
  for (var id in cart){ var p = PROD[id], q = cart[id]; t += q * p[1]; c++;
    h += '<li><span>'+esc(p[0])+'<small>'+rp(p[1])+' x '+q+'</small></span><span><button type="button" class="btn" data-m="'+id+'">-</button> <button type="button" class="btn" data-p="'+id+'">+</button></span></li>'; }
  document.getElementById('cartl').innerHTML = h; document.getElementById('kosong').style.display = c ? 'none' : 'block';
  document.getElementById('tot').textContent = rp(t); document.getElementById('cartin').value = JSON.stringify(cart); }
document.getElementById('pg').onclick = function(ev){ var b = ev.target.closest('.pbtn'); if (!b) return; var id = b.dataset.id;
  if ((cart[id] || 0) < PROD[id][2]) { cart[id] = (cart[id] || 0) + 1; render(); } };
document.getElementById('cartl').onclick = function(ev){ var b = ev.target.closest('button'); if (!b) return;
  if (b.dataset.p && cart[b.dataset.p] < PROD[b.dataset.p][2]) { cart[b.dataset.p]++; }
  if (b.dataset.m) { cart[b.dataset.m]--; if (cart[b.dataset.m] < 1) { delete cart[b.dataset.m]; } }
  render(); };
document.getElementById('cari').oninput = grid;
document.getElementById('fk').onsubmit = function(ev){ if (!Object.keys(cart).length) { ev.preventDefault(); alert('Keranjang masih kosong.'); } };
grid(); render();
<?php } ?>
</script>
</body></html>