<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/sidebar'); ?>
<div class="page-wrapper">
<style>
body{
    background:linear-gradient(135deg,#eef2f7,#f8fbff);
}

.page-title{
    font-weight:700;
    margin-bottom:25px;
}

.stat-card{
    background:#fff;
    border-radius:18px;
    padding:25px;
    box-shadow:0 10px 30px rgba(0,0,0,.06);
    transition:.3s;
    position:relative;
    overflow:hidden;
}

.stat-card:hover{
    transform:translateY(-6px);
}

.stat-icon{
    width:55px;
    height:55px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:24px;
    margin-bottom:10px;
}

.stat-primary{ background:rgba(13,110,253,.1); color:#0d6efd; }
.stat-success{ background:rgba(25,135,84,.1); color:#198754; }
.stat-warning{ background:rgba(255,193,7,.15); color:#ff9800; }

.stat-number{
    font-size:32px;
    font-weight:700;
}

.custom-card{
    background:#fff;
    border-radius:18px;
    box-shadow:0 8px 25px rgba(0,0,0,.06);
    padding:25px;
    margin-bottom:25px;
}

.table{
    border-radius:15px;
    overflow:hidden;
}

.table thead{
    background:linear-gradient(90deg,#0d6efd,#4e73df);
    color:#fff;
}

.table tbody tr{
    transition:.2s;
}

.table tbody tr:hover{
    background:#f1f5ff;
    transform:scale(1.01);
}

.btn{
    border-radius:12px;
    font-weight:500;
}

.input-icon{
    position:relative;
}

.input-icon span{
    position:absolute;
    left:12px;
    top:50%;
    transform:translateY(-50%);
    color:#888;
}

.input-icon input{
    padding-left:38px;
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

<h3 class="page-title">👥 Dashboard Pengunjung</h3>

<!-- ===== STATISTIK ===== -->
<div class="row mb-4">

<div class="col-md-4">
<div class="stat-card">
<div class="stat-icon stat-primary">📅</div>
<div class="text-muted">Hari Ini</div>
<div class="stat-number text-primary">
<?= $total_hari_ini ?? 0 ?>
</div>
<small class="text-muted"><?= date('d F Y') ?></small>
</div>
</div>

<div class="col-md-4">
<div class="stat-card">
<div class="stat-icon stat-success">📆</div>
<div class="text-muted">Minggu Ini</div>
<div class="stat-number text-success">
<?= $total_minggu_ini ?? 0 ?>
</div>
<small class="text-muted">
<?= date('d M') ?> - <?= date('d M Y', strtotime('sunday this week')) ?>
</small>
</div>
</div>

<div class="col-md-4">
<div class="stat-card">
<div class="stat-icon stat-warning">🗓</div>
<div class="text-muted">Bulan Ini</div>
<div class="stat-number text-warning">
<?= $total_bulan_ini ?? 0 ?>
</div>
<small class="text-muted"><?= date('F Y') ?></small>
</div>
</div>

</div>

<!-- BUTTON RANKING -->
<div class="text-center mb-4">
<a href="<?= base_url('index.php/pengunjung/ranking') ?>"
   class="btn btn-dark px-4 py-2 shadow-sm">
   🏆 Ranking Pengunjung Teraktif
</a>
</div>

<!-- ===== FILTER & INPUT ===== -->
<div class="custom-card">

<form method="get" id="formFilter" class="row g-3 mb-4">
<form method="get" id="formFilter" class="row g-3 mb-4">

<div class="col-md-3">
<select name="filter" id="filterSelect" class="form-control">
<option value="">Semua Data</option>
<option value="harian" <?= $this->input->get('filter')=='harian'?'selected':'' ?>>Hari Ini</option>
<option value="mingguan" <?= $this->input->get('filter')=='mingguan'?'selected':'' ?>>Minggu Ini</option>
<option value="bulanan" <?= $this->input->get('filter')=='bulanan'?'selected':'' ?>>Bulan Ini</option>
<option value="tahunan" <?= $this->input->get('filter')=='tahunan'?'selected':'' ?>>Tahun Ini</option>
</select>
</div>

<div class="col-md-3">
<select name="sort" id="sortSelect" class="form-control">
<option value="">Urutkan</option>
<option value="terbaru" <?= $this->input->get('sort')=='terbaru'?'selected':'' ?>>Terbaru</option>
<option value="terlama" <?= $this->input->get('sort')=='terlama'?'selected':'' ?>>Terlama</option>
</select>
</div>

</form>


<?php if($this->session->flashdata('error')): ?>
<div class="alert alert-danger">
⚠ <?= $this->session->flashdata('error') ?>
</div>
<?php endif ?>

<form method="post"
action="<?= base_url('index.php/pengunjung/tambah')?>"
class="row g-3 align-items-center">

<div class="col-md-4">
<div class="input-icon">
<span>🆔</span>
<input name="nis"
class="form-control"
placeholder="Masukkan NIS Pengunjung"
autofocus required>
</div>
</div>

<div class="col-md-2">
<button class="btn btn-success w-100 shadow-sm">
➕ Input
</button>
</div>

</form>

</div>

<!-- ===== TABEL ===== -->
<div class="custom-card">
<div class="table-responsive">

<table class="table table-hover align-middle">

<thead>
<tr>
<th width="60">No</th>
<th width="120">NIS</th>
<th>Nama Pengunjung</th>
<th width="160">Tanggal</th>
<th width="160">Keperluan</th>
<th width="120">Aksi</th>
</tr>
</thead>

<tbody>

<?php if(!empty($pengunjung)){ ?>
<?php $no=1; foreach($pengunjung as $p){ ?>

<tr>
<td><?= $no++ ?></td>
<td><?= $p->nis ?></td>
<td><?= $p->nama_pengunjung ?></td>
<td><?= date('d-m-Y', strtotime($p->tanggal)) ?></td>
<td>
<span class="badge bg-primary px-3 py-2">
<?= $p->keperluan ?>
</span>
</td>

<td>
<?php if($this->session->userdata('level')=='superadmin'){ ?>
<a href="<?= base_url('index.php/pengunjung/hapus/'.$p->id_pengunjung) ?>"
   class="btn btn-danger btn-sm"
   onclick="return confirm('Yakin ingin menghapus data ini?')">
   🗑 Hapus
</a>
<?php } ?>
</td>

</tr>
</tr>

<?php } ?>
<?php } else { ?>

<tr>
<td colspan="5" class="text-center text-muted py-4">
📭 Tidak ada data pengunjung
</td>
</tr>

<?php } ?>

</tbody>
</table>

</div>
</div>

</div>

<script>
document.getElementById("filterSelect")
.addEventListener("change",function(){
document.getElementById("formFilter").submit();
});

document.getElementById("sortSelect")
.addEventListener("change",function(){
document.getElementById("formFilter").submit();
});
</script>

</div>
<?php $this->load->view('template/footer'); ?>
