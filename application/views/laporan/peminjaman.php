<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/sidebar'); ?>
<div class="page-wrapper">
<style>
body{ background:#f4f6f9; }
.page-title{ font-weight:600; margin-bottom:20px; }
.custom-card{
    background:#fff;
    border-radius:15px;
    box-shadow:0 8px 25px rgba(0,0,0,.06);
    padding:20px;
    margin-bottom:20px;
}
.table{ border-radius:12px; overflow:hidden; }
.table thead{ background:linear-gradient(90deg,#0d6efd,#4e73df); color:white; }
.table tbody tr:hover{ background:#f1f5ff; }
.btn{ border-radius:10px; }
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

<h3 class="page-title">📊 Laporan Peminjaman</h3>

<!-- FILTER -->
<div class="custom-card">
<form method="get" id="formFilter">

<div class="row g-2">

<div class="col-md-4">
<input type="text" name="q" class="form-control auto-submit"
placeholder="Cari anggota / buku..."
value="<?= $this->input->get('q') ?>">
</div>

<div class="col-md-3">
<select name="status" class="form-control auto-submit">
<option value="">Semua Status</option>
<?php
$statusList=['dipinjam','dikembalikan','rusak','hilang'];
foreach($statusList as $s){
$selected=$this->input->get('status')==$s?'selected':'';
echo "<option value='$s' $selected>".ucfirst($s)."</option>";
}
?>
</select>
</div>

<div class="col-md-3">
<select name="filter" class="form-control auto-submit">
<option value="">Semua Waktu</option>
<?php
$waktu=[
'harian'=>'Hari Ini',
'mingguan'=>'Minggu Ini',
'bulanan'=>'Bulan Ini',
'tahunan'=>'Tahun Ini'
];
foreach($waktu as $k=>$v){
$sel=$this->input->get('filter')==$k?'selected':'';
echo "<option value='$k' $sel>$v</option>";
}
?>
</select>
</div>

<div class="col-md-2">
<input type="date" name="tanggal"
class="form-control auto-submit"
value="<?= $this->input->get('tanggal') ?>">
</div>

</div>
</form>
</div>

<!-- TOTAL + EXPORT -->
<div class="d-flex justify-content-between align-items-center mb-3">

<div class="alert alert-info mb-0">
Total Data: <b><?= $total ?? 0 ?></b>
</div>

<a target="_blank"
href="<?= base_url('index.php/laporan/peminjaman_pdf?'.http_build_query($_GET)) ?>"
class="btn btn-danger">
📄 Export PDF
</a>

</div>

<!-- TABEL -->
<div class="custom-card">
<div class="table-responsive">

<table class="table table-hover align-middle">

<thead>
<tr>
<th>No</th>
<th>NIS</th>
<th>Anggota</th>
<th>Buku</th>
<th>Jumlah</th>
<th>Tgl Pinjam</th>
<th>Jatuh Tempo</th>
<th>Tgl Dikembalikan</th>
<th>Status</th>
<?php if($this->session->userdata('level')=='superadmin'){ ?>
<th>Aksi</th>
<?php } ?>
</tr>
</thead>

<tbody>

<?php if(!empty($data)){ $no=1; foreach($data as $d){

$status=$d->status ?? 'dipinjam';

$badge=[
'dipinjam'=>'warning',
'dikembalikan'=>'success',
'rusak'=>'danger',
'hilang'=>'dark'
];
?>

<tr>
<td><?= $no++ ?></td>
<td><?= $d->nis ?? '-' ?></td>
<td><?= $d->nama ?? '-' ?></td>
<td><?= $d->judul ?? '-' ?></td>
<td><?= $d->jumlah ?? 0 ?></td>
<td><?= $d->tanggal_pinjam ?? '-' ?></td>
<td><?= $d->tanggal_kembali ?? '-' ?></td>
<td><?= $d->tanggal_dikembalikan ?: '-' ?></td>

<td>
<span class="badge bg-<?= $badge[$status] ?? 'secondary' ?>">
<?= ucfirst($status) ?>
</span>
</td>

<?php if($this->session->userdata('level')=='superadmin'){ ?>
<td>
<a href="<?= base_url('index.php/laporan/hapus/'.$d->id_detail) ?>"
onclick="return confirm('Hapus data ini?')"
class="btn btn-sm btn-danger">
🗑 Hapus
</a>
</td>
<?php } ?>

</tr>

<?php }}else{ ?>

<tr>
<td colspan="<?= $this->session->userdata('level')=='superadmin' ? 10 : 9 ?>"
class="text-center text-muted py-4">
Tidak ada data
</td>
</tr>

<?php } ?>

</tbody>
</table>

</div>
</div>

</div>

<script>
document.querySelectorAll(".auto-submit")
.forEach(el=>{
el.addEventListener("change",()=>{
document.getElementById("formFilter").submit();
});
});

document.querySelector("input[name=q]")
.addEventListener("keypress",function(e){
if(e.key==="Enter"){
e.preventDefault();
document.getElementById("formFilter").submit();
}
});
</script>
</div>
<?php $this->load->view('template/footer'); ?>
