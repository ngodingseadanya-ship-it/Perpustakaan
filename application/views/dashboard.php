<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/sidebar'); ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
body{
    background:linear-gradient(135deg,#eef2f7,#f8fbff);
}
.dashboard-title{ font-weight:700;margin-bottom:25px; }

.stat-card{
    background:#fff;
    border-radius:20px;
    padding:25px;
    box-shadow:0 10px 25px rgba(0,0,0,.06);
    transition:.3s;
    position:relative;
    overflow:hidden;
}
.stat-card.clickable{ cursor:pointer; }
.stat-card.clickable:hover{ transform:translateY(-8px); }

.stat-icon{
    width:55px;height:55px;border-radius:15px;
    display:flex;align-items:center;justify-content:center;
    font-size:22px;margin-bottom:15px;color:#fff;
}

.bg-blue{ background:linear-gradient(45deg,#0d6efd,#4e73df); }
.bg-teal{ background:linear-gradient(45deg,#20c997,#17a2b8); }
.bg-orange{ background:linear-gradient(45deg,#ff9800,#ff5722); }
.bg-red{ background:linear-gradient(45deg,#dc3545,#ff6b6b); }
.bg-green{ background:linear-gradient(45deg,#198754,#20c997); }
.bg-purple{ background:linear-gradient(45deg,#6f42c1,#9b59b6); }

.stat-number{ font-size:32px;font-weight:700; }
.stat-label{ color:#777; }
.stat-sub{ font-size:13px;color:#aaa; }

.trend-up{ color:#198754;font-size:13px; }
.trend-down{ color:#dc3545;font-size:13px; }

.chart-card{
    background:#fff;
    border-radius:20px;
    padding:30px;
    box-shadow:0 10px 25px rgba(0,0,0,.06);
    margin-top:40px;
}

.info-box{
    background:#fff;
    border-radius:18px;
    padding:20px;
    box-shadow:0 5px 18px rgba(0,0,0,.05);
}

.alert-overdue{
    background:#ffe5e5;
    border-left:5px solid #dc3545;
    padding:15px 20px;
    border-radius:12px;
    font-weight:600;
    color:#b02a37;
}

canvas{
opacity:0;
transition:.5s;
}
canvas.loaded{
opacity:1;
}
</style>

<div class="container-fluid">

<h3 class="dashboard-title">📊 Dashboard Perpustakaan</h3>

<div class="row g-4">

<!-- ANGGOTA -->
<div class="col-md-4">
<div class="stat-card">
<div class="stat-icon bg-blue">👥</div>
<div class="stat-number text-primary counter" data-target="<?= $anggota ?>">0</div>
<div class="stat-label">Total Anggota</div>
<div class="<?= $growth_anggota >=0 ? 'trend-up':'trend-down' ?>">
<?= $growth_anggota >=0 ? '▲':'▼' ?> <?= abs($growth_anggota) ?>% dari minggu lalu
</div>
</div>
</div>

<!-- BUKU -->
<div class="col-md-4">
<div class="stat-card">
<div class="stat-icon bg-teal">📚</div>
<div class="stat-number text-info counter" data-target="<?= $buku ?>">0</div>
<div class="stat-label">Total Buku</div>
<div class="stat-sub">Koleksi tersedia</div>
</div>
</div>

<!-- KATEGORI -->
<div class="col-md-4">
<div class="stat-card">
<div class="stat-icon bg-orange">🗂</div>
<div class="stat-number text-warning counter" data-target="<?= $kategori ?>">0</div>
<div class="stat-label">Kategori</div>
</div>
</div>

<!-- PENGUNJUNG -->
<div class="col-md-4">
<div class="stat-card clickable" onclick="showChart('pengunjung')">
<div class="stat-icon bg-red">👣</div>
<div class="stat-number text-danger counter" data-target="<?= $pengunjung ?>">0</div>
<div class="stat-label">Total Pengunjung</div>
<div class="<?= $growth_pengunjung >=0 ? 'trend-up':'trend-down' ?>">
<?= $growth_pengunjung >=0 ? '▲':'▼' ?> <?= abs($growth_pengunjung) ?>%
</div>
</div>
</div>

<!-- DIPINJAM -->
<div class="col-md-4">
<div class="stat-card clickable" onclick="showChart('peminjaman')">
<div class="stat-icon bg-green">📖</div>
<div class="stat-number text-success counter" data-target="<?= $dipinjam ?>">0</div>
<div class="stat-label">Sedang Dipinjam</div>
</div>
</div>

<!-- KEMBALI -->
<div class="col-md-4">
<div class="stat-card clickable" onclick="showChart('pengembalian')">
<div class="stat-icon bg-purple">✅</div>
<div class="stat-number text-secondary counter" data-target="<?= $kembali ?>">0</div>
<div class="stat-label">Sudah Dikembalikan</div>
</div>
</div>

</div>

<?php if($overdue > 0): ?>
<div class="alert-overdue mt-4">
⚠ <?= $overdue ?> Peminjaman Terlambat — Segera tindak lanjuti
</div>
<?php endif; ?>

<div class="chart-card">
<h5 class="mb-4">📈 Grafik Statistik</h5>
<canvas id="grafikUtama" height="100"></canvas>
</div>

<div class="row mt-4 g-4">

<div class="col-md-4">
<div class="info-box">
<h6>🔥 Buku Terpopuler</h6>
<?php if($buku_populer): ?>
<b><?= $buku_populer->judul ?></b><br>
Dipinjam <?= $buku_populer->total ?> kali
<?php else: ?>
Belum ada data
<?php endif; ?>
</div>
</div>

<div class="col-md-4">
<div class="info-box">
<h6>📅 Aktivitas Hari Ini</h6>
- <?= $pinjam_hari ?> dipinjam<br>
- <?= $kembali_hari ?> dikembalikan<br>
- <?= $anggota_hari ?> anggota baru
</div>
</div>

</div>

</div>

<script>
window.addEventListener("load", function(){

const dataChart = {
pengunjung:{
label:"Pengunjung",
labels:<?= json_encode(array_column($grafik_pengunjung,'tanggal')) ?>,
data:<?= json_encode(array_column($grafik_pengunjung,'total')) ?>
},
peminjaman:{
label:"Peminjaman",
labels:<?= json_encode(array_column($grafik_peminjaman,'tanggal')) ?>,
data:<?= json_encode(array_column($grafik_peminjaman,'total')) ?>
},
pengembalian:{
label:"Pengembalian",
labels:<?= json_encode(array_column($grafik_pengembalian,'tanggal')) ?>,
data:<?= json_encode(array_column($grafik_pengembalian,'total')) ?>
}
};

let chart=null;
const ctx=document.getElementById("grafikUtama");

function renderChart(type){

if(!dataChart[type]) return;

if(chart){
chart.data.labels=dataChart[type].labels;
chart.data.datasets[0].data=dataChart[type].data;
chart.data.datasets[0].label=dataChart[type].label;
chart.update();
}else{
chart=new Chart(ctx,{
type:"line",
data:{
labels:dataChart[type].labels,
datasets:[{
label:dataChart[type].label,
data:dataChart[type].data,
borderWidth:3,
fill:true,
tension:.4
}]
},
options:{
responsive:true,
animation:{duration:800}
}
});
}

ctx.classList.add("loaded");
}

window.showChart=function(type){
renderChart(type);
};

renderChart("pengunjung");

/* ANIMATED COUNTER */
document.querySelectorAll(".counter").forEach(el=>{
let target=parseInt(el.dataset.target)||0;
let count=0;

if(target===0){
el.innerText=0;
return;
}

let step=Math.ceil(target/40);

let interval=setInterval(()=>{
count+=step;
if(count>=target){
el.innerText=target.toLocaleString();
clearInterval(interval);
}else{
el.innerText=count.toLocaleString();
}
},20);
});

});
</script>

<?php $this->load->view('template/footer'); ?>