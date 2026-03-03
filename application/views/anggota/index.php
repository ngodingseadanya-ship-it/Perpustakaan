<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/sidebar'); ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
body{background:#f1f4f9;}

.card-ui{
background:#fff;
border-radius:18px;
padding:25px;
margin-bottom:25px;
box-shadow:0 12px 30px rgba(0,0,0,0.05);
transition:.25s;
}
.card-ui:hover{transform:translateY(-3px);}

.title-page{
font-weight:700;
font-size:24px;
display:flex;
align-items:center;
gap:12px;
margin-bottom:25px;
flex-wrap:wrap;
}

.section-title{
font-weight:600;
margin-bottom:20px;
border-left:5px solid #0d6efd;
padding-left:10px;
}

.form-control{border-radius:10px;}
.form-control:focus{
border-color:#0d6efd;
box-shadow:0 0 0 .2rem rgba(13,110,253,.15);
}

.table{
border-collapse:separate;
border-spacing:0 12px;
min-width:700px;
}
.table thead th{
background:linear-gradient(45deg,#0d6efd,#4e73df);
color:white;
border:none;
}
.table tbody tr{
background:#fff;
box-shadow:0 4px 18px rgba(0,0,0,0.05);
transition:.2s;
}
.table tbody tr:hover{transform:scale(1.01);}
.table td{border:none;vertical-align:middle;}

.btn{border-radius:10px;}
.btn-primary{background:linear-gradient(45deg,#0d6efd,#4e73df);border:none;}
.btn-warning{background:linear-gradient(45deg,#ffc107,#ffb300);border:none;}
.btn-danger{background:linear-gradient(45deg,#dc3545,#c82333);border:none;}

.stat-box{
background:linear-gradient(45deg,#0d6efd,#4e73df);
color:white;
padding:18px;
border-radius:15px;
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:25px;
flex-wrap:wrap;
}
.stat-box i{font-size:28px;opacity:.8;}

.search-icon{
position:absolute;
left:12px;
top:50%;
transform:translateY(-50%);
color:#999;
}
.search-input{padding-left:35px;}

.fade-in-up {
opacity:0;
transform:translateY(20px);
animation:fadeUp .6s ease forwards;
}
.fade-delay-1{animation-delay:.1s;}
.fade-delay-2{animation-delay:.2s;}
.fade-delay-3{animation-delay:.3s;}
.fade-delay-4{animation-delay:.4s;}

@keyframes fadeUp{
to{opacity:1;transform:translateY(0);}
}

/* Responsive fix */
@media(max-width:768px){
.card-ui{padding:18px;}
.title-page{font-size:20px;}
.stat-box{flex-direction:column;align-items:flex-start;gap:10px;}
}
</style>

<?php if($this->session->flashdata('success')){ ?>
<script>
Swal.fire({
icon:'success',
title:'Berhasil',
text:'<?= html_escape($this->session->flashdata('success')) ?>',
timer:1800,
showConfirmButton:false
})
</script>
<?php } ?>

<?php if($this->session->flashdata('error')){ ?>
<script>
Swal.fire({
icon:'error',
title:'Oops',
text:'<?= html_escape($this->session->flashdata('error')) ?>'
})
</script>
<?php } ?>

<div class="container-fluid">

<div class="title-page">
<i class="bi bi-people-fill text-primary"></i>
Data Anggota
</div>

<div class="stat-box">
<div>
<div style="font-size:13px;opacity:.8">Total Anggota</div>
<div style="font-size:26px;font-weight:700">
<?= $this->db->count_all('anggota'); ?>
</div>
</div>
<i class="bi bi-mortarboard-fill"></i>
</div>

<!-- FORM TAMBAH -->
<div class="card-ui fade-in-up fade-delay-1">
<div class="section-title">Tambah Anggota</div>

<form method="post" action="<?= base_url('index.php/anggota/tambah')?>" class="row g-3">

<div class="col-12 col-md-2">
<input name="nis" class="form-control" placeholder="NIS" required>
</div>

<div class="col-12 col-md-3">
<input name="nama" class="form-control" placeholder="Nama Lengkap" required>
</div>

<div class="col-12 col-md-2">
<select name="kelas" class="form-control" required>
<option value="">Pilih Kelas</option>
<option>10 IPA 1</option>
<option>10 IPA 2</option>
<option>10 IPS 1</option>
<option>10 IPS 2</option>
<option>11 IPA 1</option>
<option>11 IPA 2</option>
<option>11 IPS 1</option>
<option>11 IPS 2</option>
<option>12 IPA 1</option>
<option>12 IPA 2</option>
<option>12 IPA 3</option>
<option>12 IPS 1</option>
<option>12 IPS 2</option>
<option value="Alumni">Alumni</option>
</select>
</div>

<div class="col-12 col-md-3">
<input name="alamat" class="form-control" placeholder="Alamat">
</div>

<div class="col-12 col-md-2">
<input name="no_hp" class="form-control" placeholder="WhatsApp">
</div>

<div class="col-12 text-end">
<button class="btn btn-primary px-4 w-100 w-md-auto">
<i class="bi bi-plus-circle"></i> Tambah Anggota
</button>
</div>

</form>
</div>

<!-- FILTER -->
<div class="card-ui fade-in-up fade-delay-2">
<div class="section-title">Filter Anggota</div>

<form method="get" class="row g-3" id="formFilter">

<div class="col-12 col-md-4 position-relative">
<i class="bi bi-search search-icon"></i>
<input name="q"
class="form-control search-input"
placeholder="Cari Nama / NIS"
value="<?= html_escape($this->input->get('q')) ?>">
</div>

<div class="col-12 col-md-3">
<select name="kelas" id="filterKelas" class="form-control" onchange="this.form.submit()">
<option value="">Semua Kelas</option>
<?php foreach($kelas as $k){ ?>
<option value="<?= html_escape($k->kelas) ?>"
<?= $this->input->get('kelas')==$k->kelas?'selected':'' ?>>
<?= html_escape($k->kelas) ?>
</option>
<?php } ?>
</select>
</div>

<div class="col-12 col-md-2">
<select name="sort" class="form-control" onchange="this.form.submit()">
<option value="desc" <?= ($sort=='desc')?'selected':'' ?>>Terbaru</option>
<option value="asc" <?= ($sort=='asc')?'selected':'' ?>>Terlama</option>
</select>
</div>

<div class="col-12 col-md-2">
<button class="btn btn-secondary w-100">
<i class="bi bi-funnel"></i> Filter
</button>
</div>

</form>
</div>

<!-- TABEL -->
<div class="card-ui fade-in-up fade-delay-4">
<div class="section-title">Daftar Anggota</div>

<div class="table-responsive">
<table class="table align-middle">
<thead>
<tr>
<th width="60">No</th>
<th>NIS</th>
<th>Nama</th>
<th>Kelas</th>
<th>Alamat</th>
<th width="170">Aksi</th>
</tr>
</thead>

<tbody>

<?php 
$page = (int)$this->input->get('page');
$no = ($page) ? $page+1 : 1;

if(!empty($anggota)){ 
foreach($anggota as $a){ ?>

<tr>
<td><?= $no++ ?></td>
<td><?= html_escape($a->nis) ?></td>
<td><?= html_escape($a->nama) ?></td>
<td><span class="badge bg-primary"><?= html_escape($a->kelas) ?></span></td>
<td><?= html_escape($a->alamat) ?></td>
<td>

<a class="btn btn-warning btn-sm w-100 mb-2"
href="<?= base_url('index.php/anggota/edit/'.$a->id_anggota)?>">
<i class="bi bi-pencil-square"></i> Edit
</a>

<button class="btn btn-danger btn-sm w-100 btn-hapus"
data-url="<?= base_url('index.php/anggota/hapus/'.$a->id_anggota)?>">
<i class="bi bi-trash"></i> Hapus
</button>

</td>
</tr>

<?php }}else{ ?>

<tr>
<td colspan="6" class="text-center text-muted py-4">
Belum ada data anggota
</td>
</tr>

<?php } ?>

</tbody>
</table>
</div>

<div class="mt-4">
<?= $pagination ?? '' ?>
</div>

</div>

</div>

<script>
document.querySelectorAll('.btn-hapus').forEach(btn=>{
btn.addEventListener('click',function(){
let url=this.dataset.url
Swal.fire({
title:'Hapus anggota?',
text:'Data tidak bisa dikembalikan',
icon:'warning',
showCancelButton:true,
confirmButtonColor:'#d33',
confirmButtonText:'Ya hapus',
cancelButtonText:'Batal'
}).then((result)=>{
if(result.isConfirmed){
window.location.href=url
}
})
})
})

document.getElementById("filterKelas").addEventListener("change",function(){
document.getElementById("formFilter").submit();
});
</script>

<?php $this->load->view('template/footer'); ?>