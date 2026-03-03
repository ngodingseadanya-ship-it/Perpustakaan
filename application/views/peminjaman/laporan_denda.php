<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/sidebar'); ?>
<div class="page-wrapper">
<style>
.page-title{
    font-weight:700;
}

.summary-card{
    border-radius:18px;
    padding:20px;
    color:#fff;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
}

.bg-total{ background:linear-gradient(45deg,#0d6efd,#4e73df); }
.bg-lunas{ background:linear-gradient(45deg,#198754,#20c997); }
.bg-belum{ background:linear-gradient(45deg,#dc3545,#ff6b6b); }

.table thead{
    font-size:14px;
    letter-spacing:.5px;
}

.badge{
    font-size:12px;
    padding:6px 10px;
}

.filter-card{
    border-radius:18px;
}

tfoot{
    font-size:16px;
    font-weight:600;
}
/* ===== PAGE LOAD ANIMATION ===== */

.page-wrapper{
    opacity:0;
    transform:translateY(20px);
    animation:pageFade .6s ease forwards;
}

@keyframes pageFade{
    to{
        opacity:1;
        transform:translateY(0);
    }
}

/* CARD ANIMATION */
.custom-card{
    opacity:0;
    transform:translateY(15px);
    animation:cardFade .6s ease forwards;
}

.custom-card:nth-child(1){
    animation-delay:.2s;
}
.custom-card:nth-child(2){
    animation-delay:.4s;
}

@keyframes cardFade{
    to{
        opacity:1;
        transform:translateY(0);
    }
}

/* TABLE ROW FADE */
.table tbody tr{
    opacity:0;
    transform:translateY(10px);
    animation:rowFade .4s ease forwards;
}

.table tbody tr:nth-child(odd){
    animation-delay:.1s;
}
.table tbody tr:nth-child(even){
    animation-delay:.2s;
}

@keyframes rowFade{
    to{
        opacity:1;
        transform:translateY(0);
    }
}
</style>

<div class="container-fluid">

<h4 class="mb-4 page-title">💰 Laporan Denda</h4>

<?php
$total=0;
$total_lunas=0;
$total_belum=0;

if(!empty($data)){
    foreach($data as $d){
        $total += $d->denda;
        if($d->status_bayar=='lunas'){
            $total_lunas += $d->denda;
        }else{
            $total_belum += $d->denda;
        }
    }
}
?>

<!-- SUMMARY -->
<div class="row mb-4">

<div class="col-md-4">
<div class="summary-card bg-total">
<h6>Total Denda</h6>
<h3>Rp <?= number_format($total) ?></h3>
</div>
</div>

<div class="col-md-4">
<div class="summary-card bg-lunas">
<h6>Total Lunas</h6>
<h3>Rp <?= number_format($total_lunas) ?></h3>
</div>
</div>

<div class="col-md-4">
<div class="summary-card bg-belum">
<h6>Belum Dibayar</h6>
<h3>Rp <?= number_format($total_belum) ?></h3>
</div>
</div>

</div>

<!-- FILTER -->
<div class="card shadow-sm mb-4 filter-card">
<div class="card-body">

<form method="get" class="row g-3 align-items-end">

<div class="col-md-3">
<label class="form-label">Filter Tanggal</label>
<input type="date" name="tanggal" class="form-control"
value="<?= $tanggal ?>">
</div>

<div class="col-md-2">
<button class="btn btn-primary w-100">🔍 Filter</button>
</div>

<div class="col-md-2">
<a href="<?= base_url('index.php/peminjaman/laporan_denda') ?>"
class="btn btn-secondary w-100">
↻ Reset
</a>
</div>

</form>

</div>
</div>
<a href="#" 
onclick="window.open('<?= base_url('index.php/peminjaman/export_denda') ?>','_blank')"
class="btn btn-danger mb-3">
Export PDF
</a>

<!-- TABLE -->
<div class="card shadow-sm">
<div class="card-body table-responsive">

<table class="table table-hover align-middle">
<thead class="table-dark text-center">
<tr>
<th>No</th>
<th>NIS</th>
<th>Nama</th>
<th>Buku</th>
<th>Denda</th>
<th>Status</th>
<th>Tgl Bayar</th>
</tr>
</thead>
<tbody>

<?php 
if(!empty($data)){
$no=1;
foreach($data as $d){
?>

<tr class="<?= $d->status_bayar=='belum' ? 'table-danger' : '' ?>">
<td class="text-center"><?= $no++ ?></td>
<td><?= $d->nis ?></td>
<td><?= $d->nama ?></td>
<td><?= $d->judul ?></td>
<td class="fw-bold text-danger">
Rp <?= number_format($d->denda) ?>
</td>
<td class="text-center">
<?= $d->status_bayar=='lunas'
? '<span class="badge bg-success">✔ Lunas</span>'
: '<span class="badge bg-danger">✖ Belum</span>' ?>
</td>
<td class="text-center">
<?= $d->tanggal_bayar ?: '-' ?>
</td>
</tr>

<?php }}else{ ?>
<tr>
<td colspan="7" class="text-center text-muted py-4">
Belum ada data denda
</td>
</tr>
<?php } ?>

</tbody>

<tfoot class="table-light">
<tr>
<th colspan="4" class="text-end">Total Keseluruhan</th>
<th colspan="3">Rp <?= number_format($total) ?></th>
</tr>
</tfoot>

</table>

</div>
</div>

</div>
</div>
<?php $this->load->view('template/footer'); ?>