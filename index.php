<!DOCTYPE html>
<html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>KASARA</title>
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
  <a class="logo" href="#beranda"><svg width="28" height="28" viewBox="0 0 28 28" fill="none" stroke="#22d3ee" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 22c8 0 14-4 17-13"/><path d="M14 8h8v8"/></svg>KASARA <small>v1.1 (Premium)</small></a>
  <div class="right"><a class="bell" id="bell" href="#produk/rendah" title="Stok rendah"></a><div class="me" id="me"></div></div>
</header>
<div class="wrap"><nav class="side" id="nav" aria-label="Menu utama"></nav><main id="app"></main></div>
<div class="fab noprint" aria-label="Akses cepat"><a href="#produk">[+] Tambah Stok Cepat</a><a href="#pelanggan">[+] Tambah Pelanggan</a><a href="#panduan">[?] Buka Buku Panduan</a></div>

<script>
// KASARA - versi statis untuk Vercel. Data disimpan di localStorage browser (tanpa database).
var KEY = 'kasara-v1';
var rp = function (n) { return 'Rp ' + Math.round(n).toLocaleString('id-ID'); };
var esc = function (t) { return String(t).replace(/[&<>"']/g, function (c) { return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]; }); };
function seed() {
  return { nama: 'Jane Doe', toko: 'Toko KASARA', no: 45, nw: 0, nsum: 0, nid: 11,
    prod: [[1,'Beras Premium 5kg',68000,40,10],[2,'Minyak Goreng 2L',36000,6,10],[3,'Gula Pasir 1kg',17000,8,10],[4,'Telur Ayam 1kg',30000,25,10],[5,'Kopi Sachet (10 pcs)',10500,4,15],
      [6,'Mie Instan',3500,120,30],[7,'Susu UHT 1L',19000,3,8],[8,'Teh Celup 25s',8500,30,10],[9,'Sabun Mandi',4500,2,10],[10,'Air Mineral 600ml',3500,90,24]].map(function (a) { return {id:a[0],n:a[1],h:a[2],s:a[3],m:a[4]}; }),
    cust: [['Budi Santoso','0812-1111-2222'],['Siti Aminah','0813-3333-4444'],['Toko Maju Jaya','0821-5555-6666'],['Rina Wijaya','0857-7777-8888'],['Ahmad Fauzi','0896-9999-0000']],
    trx: [['INV-0045','14:32','Budi Santoso','Jane Doe','QRIS',182500,'Lunas'],['INV-0044','14:10','Umum','Jane Doe','Tunai',64000,'Lunas'],['INV-0043','13:47','Siti Aminah','Rudi','Transfer',245000,'Menunggu'],
      ['INV-0042','13:21','Umum','Rudi','Tunai',38500,'Lunas'],['INV-0041','12:58','Toko Maju Jaya','Jane Doe','QRIS',410000,'Lunas']].map(function (a) { return {id:a[0],w:a[1],p:a[2],k:a[3],m:a[4],t:a[5],st:a[6],items:null}; }) };
}
var S; try { S = JSON.parse(localStorage.getItem(KEY)) || seed(); } catch (x) { S = seed(); }
function save() { try { localStorage.setItem(KEY, JSON.stringify(S)); } catch (x) {} }
var flash = '', cart = {};
var app = document.getElementById('app');
var lowCount = function () { return S.prod.filter(function (p) { return p.s <= p.m; }).length; };

var TERLARIS = [['Beras Premium 5kg',62,7210000],['Telur Ayam 1kg',71,2130000],['Minyak Goreng 2L',48,1450000],['Gula Pasir 1kg',95,1330000],['Kopi Sachet (10 pcs)',120,1260000]];
var LOYAL = [['Budi Santoso',8,1240000],['Siti Aminah',6,985000],['Toko Maju Jaya',4,870000],['Rina Wijaya',5,640000],['Ahmad Fauzi',3,515000]];
function chartData() {
  var om = 3850000 + S.nsum, lb = Math.round(om * 0.3);
  return { minggu: { label: ['Kam','Jum','Sab','Min','Sen','Sel','Rab'], omset: [3120000,3480000,4210000,4560000,3290000,3437500,om], laba: [936000,1044000,1263000,1368000,987000,1031250,lb] },
    bulan: { label: ['Mg 1','Mg 2','Mg 3','Mg 4'], omset: [22400000,24100000,23300000,26800000], laba: [6720000,7230000,6990000,8040000] },
    tahun: { label: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov'], omset: [81e6,76e6,88e6,92e6,95e6,90e6,99e6,103e6,98e6,107e6,52e6], laba: [24.3e6,22.8e6,26.4e6,27.6e6,28.5e6,27e6,29.7e6,30.9e6,29.4e6,32.1e6,15.6e6] } };
}
function tbl(head, rows) { return '<div class="tw"><table><thead><tr>' + head.map(function (h) { return '<th>' + h + '</th>'; }).join('') + '</tr></thead><tbody>' + rows + '</tbody></table></div>'; }

// ---------- HALAMAN ----------
var pages = {
  beranda: function () {
    var om = 3850000 + S.nsum, tn = 45 + S.nw, lb = Math.round(om * 0.3), up = Math.round((om - 3437500) / 3437500 * 100), sum = TERLARIS.reduce(function (a, x) { return a + x[2]; }, 0);
    var rows = S.trx.slice(0, 5).map(function (t) { return '<tr><td><a href="#struk/' + t.id + '" style="color:var(--cy)">' + t.id + '</a></td><td>' + t.w + '</td><td>' + esc(t.p) + '</td><td>' + esc(t.k) + '</td><td>' + t.m + '</td><td>' + rp(t.t) + '</td><td><span class="st ' + t.st + '">' + t.st + '</span></td></tr>'; }).join('');
    return '<h1>Ringkasan Kinerja Hari Ini</h1><section class="cards">' +
      '<div class="card cy"><span>Omset Hari Ini</span><h2>' + rp(om) + '</h2><p><b class="up">+' + up + '%</b> vs kemarin</p></div>' +
      '<a class="card cy" href="#laporan/penjualan"><span>Total Transaksi</span><h2>' + tn + '</h2><p>Rata-rata keranjang: ' + rp(Math.round(om / tn / 100) * 100) + '</p></a>' +
      '<a class="card or" href="#laporan/laba"><span>Estimasi Laba Kotor</span><h2>' + rp(lb) + '</h2><p>Margin 30%</p></a>' +
      '<a class="card rd" href="#produk/rendah"><span>Peringatan Stok</span><h2>' + lowCount() + ' Produk</h2><p>Hampir habis - klik untuk melihat</p></a></section>' +
      '<section class="grid"><div class="box"><div class="head"><h3 id="ctitle">Kinerja Penjualan Minggu Ini</h3><div class="tabs" id="range"><button class="on" data-r="minggu">Minggu Ini</button><button data-r="bulan">Bulan Ini</button><button data-r="tahun">Tahun Ini</button></div></div>' +
      '<svg id="svg" viewBox="0 0 600 260" role="img" aria-label="Grafik omset dan laba"></svg><div class="leg"><i style="background:var(--cy)"></i>Omset<i style="background:var(--or)"></i>Laba</div></div>' +
      '<div class="box"><div class="head"><h3>Rangkuman Mingguan</h3><div class="tabs" id="sum"><button class="on" data-t="p">Produk Terlaris</button><button data-t="c">Pelanggan Loyal</button></div></div>' +
      '<ol id="lp">' + TERLARIS.map(function (x, i) { return '<li><span>' + (i + 1) + '. ' + x[0] + '<small>' + x[1] + ' terjual</small></span><em>' + rp(x[2]) + '<small>' + Math.round(x[2] / sum * 100) + '% omset</small></em></li>'; }).join('') + '</ol>' +
      '<ol id="lc" class="hide">' + LOYAL.map(function (x, i) { return '<li><span>' + (i + 1) + '. ' + x[0] + '<small>' + x[1] + ' transaksi</small></span><em>' + rp(x[2]) + '</em></li>'; }).join('') + '</ol></div></section>' +
      '<section class="box"><div class="head"><h3>Daftar Transaksi Kasir (5 Terakhir)</h3><a class="btn" href="#struk/' + S.trx[0].id + '">&#128424; Cetak Ulang Struk Terakhir</a></div>' +
      tbl(['ID Struk','Waktu','Pelanggan','Kasir','Metode Bayar','Total','Status'], rows) + '</section>';
  },
  kasir: function () {
    return '<h1>Kasir Baru</h1><div class="k2"><div class="box"><div class="head"><h3>Pilih Produk</h3><input id="cari" placeholder="Cari produk..." aria-label="Cari produk"></div><div class="pgrid" id="pg"></div></div>' +
      '<form class="box" data-f="checkout"><div class="head"><h3>Keranjang</h3></div><ol id="cartl"></ol><p id="kosong" style="color:var(--mut);font-size:14px">Belum ada item.</p>' +
      '<div class="head" style="margin-top:12px"><strong>Total</strong><strong id="tot" style="color:var(--cy)">Rp 0</strong></div>' +
      '<div class="frm" style="flex-direction:column;align-items:stretch"><select name="pel" aria-label="Pelanggan"><option value="">Umum</option>' + S.cust.map(function (c) { return '<option>' + esc(c[0]) + '</option>'; }).join('') + '</select>' +
      '<select name="metode" aria-label="Metode bayar"><option>Tunai</option><option>QRIS</option><option>Transfer</option></select><button class="btn pri" type="submit">Bayar &amp; Cetak Struk</button></div></form></div>';
  },
  produk: function (f) {
    var rows = S.prod.filter(function (p) { return f !== 'rendah' || p.s <= p.m; }).map(function (p) { var lw = p.s <= p.m; return '<tr><td>' + esc(p.n) + '</td><td>' + rp(p.h) + '</td><td>' + p.s + '</td><td><span class="st ' + (lw ? 'Rendah' : 'Aman') + '">' + (lw ? 'Rendah' : 'Aman') + '</span></td></tr>'; }).join('');
    return '<h1>Produk &amp; Stok</h1><div class="box"><div class="head"><h3>Tambah Stok Cepat</h3></div><form class="frm" data-f="stok"><select name="id" aria-label="Produk">' +
      S.prod.map(function (p) { return '<option value="' + p.id + '">' + esc(p.n) + ' (stok ' + p.s + ')</option>'; }).join('') + '</select><input type="number" name="jumlah" min="1" value="10" required aria-label="Jumlah"><button class="btn pri">Tambah</button></form></div>' +
      '<div class="box"><div class="head"><h3>Daftar Produk</h3><div class="tabs"><a href="#produk" class="' + (f ? '' : 'on') + '">Semua</a><a href="#produk/rendah" class="' + (f === 'rendah' ? 'on' : '') + '">Stok Rendah</a></div></div>' + tbl(['Produk','Harga','Stok','Status'], rows) + '</div>' +
      '<div class="box"><div class="head"><h3>Produk Baru</h3></div><form class="frm" data-f="produk"><input name="nama" placeholder="Nama produk" required><input type="number" name="harga" min="1" placeholder="Harga" required><input type="number" name="stok" min="0" placeholder="Stok awal" required><button class="btn pri">Simpan</button></form></div>';
  },
  pelanggan: function () {
    return '<h1>Pelanggan</h1><div class="box"><div class="head"><h3>Tambah Pelanggan</h3></div><form class="frm" data-f="pelanggan"><input name="nama" placeholder="Nama pelanggan" required><input name="hp" placeholder="No. HP"><button class="btn pri">Simpan</button></form></div>' +
      '<div class="box">' + tbl(['#','Nama','No. HP'], S.cust.map(function (c, i) { return '<tr><td>' + (i + 1) + '</td><td>' + esc(c[0]) + '</td><td>' + esc(c[1]) + '</td></tr>'; }).join('')) + '</div>';
  },
  laporan: function (s) {
    s = s || 'penjualan'; var c = chartData().minggu, body;
    if (s === 'laba') { body = tbl(['Hari','Omset','Laba','Margin'], c.label.map(function (l, i) { return '<tr><td>' + l + '</td><td>' + rp(c.omset[i]) + '</td><td>' + rp(c.laba[i]) + '</td><td>' + Math.round(c.laba[i] / c.omset[i] * 100) + '%</td></tr>'; }).join('')); }
    else if (s === 'pajak') { var tot = c.omset.reduce(function (a, b) { return a + b; }, 0), ppn = Math.round(tot * 11 / 111);
      body = tbl(['Keterangan','Nilai'], '<tr><td>Omset 7 hari (termasuk PPN)</td><td>' + rp(tot) + '</td></tr><tr><td>Estimasi PPN 11% (sudah termasuk harga)</td><td>' + rp(ppn) + '</td></tr><tr><td>Omset sebelum PPN</td><td>' + rp(tot - ppn) + '</td></tr>'); }
    else { body = tbl(['ID Struk','Waktu','Pelanggan','Kasir','Metode','Total'], S.trx.map(function (t) { return '<tr><td><a href="#struk/' + t.id + '" style="color:var(--cy)">' + t.id + '</a></td><td>' + t.w + '</td><td>' + esc(t.p) + '</td><td>' + esc(t.k) + '</td><td>' + t.m + '</td><td>' + rp(t.t) + '</td></tr>'; }).join('')); }
    var tabs = [['penjualan','Penjualan'],['laba','Laba'],['pajak','Pajak']].map(function (x) { return '<a href="#laporan/' + x[0] + '" class="' + (s === x[0] ? 'on' : '') + '">' + x[1] + '</a>'; }).join('');
    return '<h1>Laporan</h1><div class="tabs" style="margin-bottom:14px">' + tabs + '</div><div class="box">' + body + '</div>';
  },
  pengaturan: function () {
    return '<h1>Pengaturan</h1><div class="box"><form class="frm" data-f="setting"><input name="nama" value="' + esc(S.nama) + '" aria-label="Nama admin"><input name="toko" value="' + esc(S.toko) + '" aria-label="Nama toko"><button class="btn pri">Simpan</button></form></div>' +
      '<div class="box"><p style="color:var(--mut);margin-bottom:10px">Kembalikan semua data contoh (stok, transaksi, pelanggan) ke kondisi awal.</p><button class="btn" data-act="reset">Reset Data Contoh</button></div>';
  },
  panduan: function () {
    var li = function (a, b) { return '<li><span>' + a + '<small>' + b + '</small></span></li>'; };
    return '<h1>Buku Panduan</h1><div class="box"><ol>' + li('1. Kasir Baru', 'Klik produk untuk menambah ke keranjang, atur jumlah, pilih pelanggan dan metode bayar, lalu Bayar.') +
      li('2. Produk &amp; Stok', 'Tambah stok cepat, tambah produk baru, dan lihat produk yang stoknya rendah.') + li('3. Pelanggan', 'Simpan data pelanggan agar bisa dipilih saat transaksi.') +
      li('4. Laporan', 'Penjualan, laba, dan estimasi pajak.') + li('5. Cetak Ulang', 'Klik ID Struk atau tombol Cetak Ulang di Beranda, lalu tekan Cetak.') + '</ol></div>';
  },
  struk: function (id) {
    var t = S.trx.filter(function (x) { return x.id === id; })[0];
    if (!t) { return '<h1>Struk</h1><div class="box">Struk tidak ditemukan.</div>'; }
    var items = t.items ? t.items.map(function (i) { return '<div><span>' + esc(i[0]) + ' x' + i[1] + '</span><span>' + rp(i[1] * i[2]) + '</span></div>'; }).join('') : '<div><span>(Rincian item tidak tersedia untuk data contoh)</span></div>';
    return '<h1 class="noprint">Struk</h1><div class="box struk"><div style="justify-content:center"><strong>' + esc(S.toko) + '</strong></div><hr><div><span>' + t.id + '</span><span>' + t.w + '</span></div><div><span>Pelanggan</span><span>' + esc(t.p) + '</span></div><div><span>Kasir</span><span>' + esc(t.k) + '</span></div><hr>' + items +
      '<hr><div><strong>Total</strong><strong>' + rp(t.t) + '</strong></div><div><span>Bayar</span><span>' + t.m + '</span></div><hr><div style="justify-content:center">Terima kasih</div></div>' +
      '<p class="noprint"><button class="btn pri" onclick="window.print()">&#128424; Cetak</button> <a class="btn" href="#beranda">Kembali</a></p>';
  }
};

// ---------- RENDER & ROUTER ----------
function render() {
  var h = (location.hash || '#beranda').slice(1).split('/'), p = pages[h[0]] ? h[0] : 'beranda';
  var menu = [['beranda','&#128202; Beranda'],['kasir','&#128179; Kasir Baru'],['produk','&#128230; Produk &amp; Stok'],['pelanggan','&#128101; Pelanggan'],['laporan','&#128200; Laporan'],['pengaturan','&#9881;&#65039; Pengaturan']];
  document.getElementById('nav').innerHTML = menu.map(function (m) {
    var cls = (m[0] === p || (m[0] === 'beranda' && p === 'struk') ? 'on ' : '') + (m[0] === 'kasir' ? 'kasir' : '');
    return '<a href="#' + m[0] + '" class="' + cls + '">' + m[1] + '</a>' + (m[0] === 'laporan' ? ['penjualan','laba','pajak'].map(function (s) { return '<a class="sub" href="#laporan/' + s + '">' + s.charAt(0).toUpperCase() + s.slice(1) + '</a>'; }).join('') : '');
  }).join('');
  var lc = lowCount();
  document.getElementById('bell').innerHTML = '&#128276;' + (lc ? '<b>' + lc + '</b>' : '');
  document.getElementById('me').innerHTML = '<strong>Admin</strong> - ' + esc(S.nama);
  document.title = 'KASARA - ' + p.charAt(0).toUpperCase() + p.slice(1);
  app.innerHTML = (flash ? '<div class="flash" role="status">' + esc(flash) + '</div>' : '') + pages[p](h[1]);
  flash = '';
  if (p === 'beranda') { initBeranda(); } else if (p === 'kasir') { cart = {}; kGrid(); kCart(); }
  window.scrollTo(0, 0);
}
window.addEventListener('hashchange', render);

// ---------- BERANDA: grafik ----------
function initBeranda() {
  var D = chartData(), T = {minggu:'Minggu Ini', bulan:'Bulan Ini', tahun:'Tahun Ini'};
  function draw(key) {
    var d = D[key], W = 600, H = 260, L = 52, R = 14, Tp = 14, B = 28, max = Math.max.apply(null, d.omset) * 1.1 || 1, n = d.label.length, s = '';
    var x = function (i) { return L + (n === 1 ? 0 : i * (W - L - R) / (n - 1)); }, y = function (v) { return Tp + (H - Tp - B) * (1 - v / max); };
    for (var g = 0; g <= 4; g++) { var gv = max * g / 4, gy = y(gv);
      s += '<line x1="' + L + '" x2="' + (W - R) + '" y1="' + gy + '" y2="' + gy + '" stroke="#1f2d3d"/><text x="' + (L - 6) + '" y="' + (gy + 4) + '" fill="#8a9bb0" font-size="10" text-anchor="end">' + (gv >= 1e6 ? (gv / 1e6).toFixed(1) + ' jt' : Math.round(gv / 1e3) + ' rb') + '</text>'; }
    d.label.forEach(function (l, i) { s += '<text x="' + x(i) + '" y="' + (H - 8) + '" fill="#8a9bb0" font-size="11" text-anchor="middle">' + l + '</text>'; });
    [['omset', '#22d3ee'], ['laba', '#fb923c']].forEach(function (k) {
      s += '<polyline fill="none" stroke="' + k[1] + '" stroke-width="2.5" stroke-linejoin="round" points="' + d[k[0]].map(function (v, i) { return x(i) + ',' + y(v); }).join(' ') + '"/>';
      d[k[0]].forEach(function (v, i) { s += '<circle cx="' + x(i) + '" cy="' + y(v) + '" r="4" fill="' + k[1] + '"><title>' + d.label[i] + ' - ' + k[0] + ': ' + rp(v) + '</title></circle>'; }); });
    document.getElementById('svg').innerHTML = s; document.getElementById('ctitle').textContent = 'Kinerja Penjualan ' + T[key];
  }
  function tabs(id, fn) { var bs = document.querySelectorAll('#' + id + ' button'); bs.forEach(function (b) { b.onclick = function () { bs.forEach(function (o) { o.classList.remove('on'); }); b.classList.add('on'); fn(b); }; }); }
  tabs('range', function (b) { draw(b.dataset.r); });
  tabs('sum', function (b) { document.getElementById('lp').classList.toggle('hide', b.dataset.t !== 'p'); document.getElementById('lc').classList.toggle('hide', b.dataset.t !== 'c'); });
  draw('minggu');
}

// ---------- KASIR ----------
function byId(id) { return S.prod.filter(function (p) { return p.id === +id; })[0]; }
function kGrid() {
  var q = (document.getElementById('cari').value || '').toLowerCase();
  var h = S.prod.filter(function (p) { return p.n.toLowerCase().indexOf(q) >= 0; }).map(function (p) { return '<button type="button" class="pbtn" data-add="' + p.id + '"' + (p.s < 1 ? ' disabled' : '') + '>' + esc(p.n) + '<small>' + rp(p.h) + ' - stok ' + p.s + '</small></button>'; }).join('');
  document.getElementById('pg').innerHTML = h || '<p style="color:var(--mut)">Tidak ada produk.</p>';
}
function kCart() {
  var h = '', t = 0, c = 0;
  for (var id in cart) { var p = byId(id); t += cart[id] * p.h; c++;
    h += '<li><span>' + esc(p.n) + '<small>' + rp(p.h) + ' x ' + cart[id] + '</small></span><span><button type="button" class="btn" data-dec="' + id + '">-</button> <button type="button" class="btn" data-inc="' + id + '">+</button></span></li>'; }
  document.getElementById('cartl').innerHTML = h; document.getElementById('kosong').style.display = c ? 'none' : 'block'; document.getElementById('tot').textContent = rp(t);
}

// ---------- EVENT ----------
app.addEventListener('click', function (ev) {
  var b = ev.target.closest('button'); if (!b) { return; }
  if (b.dataset.add) { var p = byId(b.dataset.add); if ((cart[p.id] || 0) < p.s) { cart[p.id] = (cart[p.id] || 0) + 1; kCart(); } }
  else if (b.dataset.inc) { if (cart[b.dataset.inc] < byId(b.dataset.inc).s) { cart[b.dataset.inc]++; kCart(); } }
  else if (b.dataset.dec) { if (--cart[b.dataset.dec] < 1) { delete cart[b.dataset.dec]; } kCart(); }
  else if (b.dataset.act === 'reset') { if (confirm('Reset semua data contoh?')) { S = seed(); save(); flash = 'Data contoh dikembalikan.'; location.hash = '#beranda'; render(); } }
});
app.addEventListener('input', function (ev) { if (ev.target.id === 'cari') { kGrid(); } });
app.addEventListener('submit', function (ev) {
  var f = ev.target.dataset.f; if (!f) { return; }
  ev.preventDefault(); var d = new FormData(ev.target), go = null;
  if (f === 'checkout') {
    var ids = Object.keys(cart), ok = ids.length > 0, items = [], total = 0;
    ids.forEach(function (id) { var p = byId(id); if (!p || cart[id] > p.s) { ok = false; } else { items.push([p.n, cart[id], p.h]); total += cart[id] * p.h; } });
    if (!ok) { alert('Keranjang masih kosong atau stok tidak cukup.'); return; }
    ids.forEach(function (id) { byId(id).s -= cart[id]; });
    S.no++; var inv = 'INV-' + String(S.no).padStart(4, '0'), now = new Date();
    S.trx.unshift({ id: inv, w: ('0' + now.getHours()).slice(-2) + ':' + ('0' + now.getMinutes()).slice(-2), p: d.get('pel') || 'Umum', k: S.nama, m: d.get('metode'), t: total, st: 'Lunas', items: items });
    S.nw++; S.nsum += total; flash = 'Transaksi ' + inv + ' berhasil disimpan.'; go = '#struk/' + inv;
  } else if (f === 'stok') {
    var p2 = byId(d.get('id')), j = parseInt(d.get('jumlah'), 10);
    if (p2 && j > 0 && j <= 100000) { p2.s += j; flash = 'Stok ' + p2.n + ' bertambah ' + j + '.'; } else { flash = 'Data stok tidak valid.'; }
    go = '#produk';
  } else if (f === 'produk') {
    var n = d.get('nama').trim(), h = parseInt(d.get('harga'), 10), s = parseInt(d.get('stok'), 10);
    if (n && h > 0 && s >= 0) { S.prod.push({ id: S.nid++, n: n.slice(0, 60), h: h, s: s, m: 10 }); flash = 'Produk ditambahkan.'; } else { flash = 'Isi nama, harga, dan stok dengan benar.'; }
    go = '#produk';
  } else if (f === 'pelanggan') {
    var nm = d.get('nama').trim(); if (nm) { S.cust.push([nm.slice(0, 60), (d.get('hp') || '').trim().slice(0, 20)]); flash = 'Pelanggan ditambahkan.'; } else { flash = 'Nama wajib diisi.'; }
    go = '#pelanggan';
  } else if (f === 'setting') {
    if (d.get('nama').trim()) { S.nama = d.get('nama').trim().slice(0, 40); } if (d.get('toko').trim()) { S.toko = d.get('toko').trim().slice(0, 40); }
    flash = 'Pengaturan disimpan.'; go = '#pengaturan';
  }
  save(); if (location.hash === go) { render(); } else { location.hash = go; }
});
render();
</script>
</body></html>
