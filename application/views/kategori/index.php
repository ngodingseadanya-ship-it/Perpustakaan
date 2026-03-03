<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/sidebar'); ?>
<?php if($this->session->flashdata('success')){ ?>
<div class="alert alert-success">
<?= $this->session->flashdata('success') ?>
</div>
<?php } ?>

<?php if($this->session->flashdata('error')){ ?>
<div class="alert alert-danger">
<?= $this->session->flashdata('error') ?>
</div>
<?php } ?>
<style>
body{
    background:#f4f6f9;
}

.custom-card{
    background:#fff;
    border-radius:15px;
    box-shadow:0 8px 25px rgba(0,0,0,0.06);
    padding:25px;
    margin-bottom:25px;
    animation:fadeIn .4s ease-in-out;
}

@keyframes fadeIn{
    from{opacity:0; transform:translateY(10px);}
    to{opacity:1; transform:translateY(0);}
}

.section-title{
    font-weight:600;
    margin-bottom:20px;
    border-left:5px solid #0d6efd;
    padding-left:10px;
}

.form-control{
    border-radius:10px;
}

.form-control:focus{
    box-shadow:0 0 0 .2rem rgba(13,110,253,.15);
    border-color:#0d6efd;
}

.table{
    border-radius:12px;
    overflow:hidden;
}

.table thead{
    background:linear-gradient(90deg,#0d6efd,#4e73df);
    color:white;
}

.table tbody tr:hover{
    background:#f1f5ff;
    transition:.2s;
}

.btn{
    border-radius:10px;
}

.btn-primary{
    background:linear-gradient(45deg,#0d6efd,#4e73df);
    border:none;
}

.btn-warning{
    background:linear-gradient(45deg,#ffc107,#ffb300);
    border:none;
    color:#000;
}

.btn-danger{
    background:linear-gradient(45deg,#dc3545,#c82333);
    border:none;
}
</style>

<h3 class="mb-4 fw-bold">📂 Data Kategori</h3>

<!-- FORM TAMBAH -->
<div class="custom-card">

<h5 class="section-title">Tambah Kategori</h5>

<form method="post" action="<?= base_url('index.php/kategori/tambah')?>" class="row g-3">

<div class="col-md-4">
<input name="nama_kategori" class="form-control" placeholder="Nama Kategori" required>
</div>

<div class="col-md-2">
<button class="btn btn-primary w-100">Tambah</button>
</div>

</form>

</div>

<!-- TABLE DATA -->
<div class="custom-card">

<h5 class="section-title">Daftar Kategori</h5>

<table class="table table-hover align-middle shadow-sm">

<thead>
<tr>
<th width="60">No</th>
<th>Nama Kategori</th>
<th width="150">Aksi</th>
</tr>
</thead>

<tbody>

<?php if(!empty($kategori)){ $no=1; foreach($kategori as $k){ ?>

<tr>
<td><?= $no++ ?></td>
<td><?= $k->nama_kategori ?></td>

<td>
<a class="btn btn-warning btn-sm mb-1 w-100"
href="<?= base_url('index.php/kategori/edit/'.$k->id_kategori)?>">
Edit
</a>

<a class="btn btn-danger btn-sm w-100"
onclick="return confirm('Yakin ingin menghapus kategori ini?')"
href="<?= base_url('index.php/kategori/hapus/'.$k->id_kategori)?>">
Hapus
</a>
</td>
</tr>

<?php }}else{ ?>

<tr>
<td colspan="3" class="text-center">Belum ada data kategori</td>
</tr>

<?php } ?>

</tbody>
</table>

</div>

<?php $this->load->view('template/footer'); ?>
