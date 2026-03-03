<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/sidebar'); ?>

<div class="page-wrapper container-fluid py-4">

<style>

/* ================= PAGE ================= */
.page-title{
    font-weight:700;
    color:#2c3e50;
    margin-bottom:20px;
}

/* ================= CARD ================= */
.custom-card{
    background:#fff;
    border-radius:18px;
    padding:22px;
    margin-bottom:25px;
    box-shadow:0 5px 20px rgba(0,0,0,0.06);
}

/* ================= SECTION TITLE ================= */
.section-title{
    font-weight:600;
    margin-bottom:18px;
    color:#34495e;
}

/* ================= FORM ================= */
.form-control, .form-select{
    border-radius:12px;
    padding:10px 14px;
}

.btn{
    border-radius:10px;
}

/* ================= TABLE ================= */
.table{
    min-width:900px;
}

.table thead{
    background:#eef2f7;
}

.table th{
    font-size:14px;
    border:none;
    color:#2c3e50;
    white-space:nowrap;
}

.table td{
    vertical-align:middle;
    border-top:1px solid #edf1f5;
}

.table tbody tr:hover{
    background:#f8fafc;
}

/* ================= COVER ================= */
.book-cover{
    width:60px;
    height:80px;
    object-fit:cover;
    border-radius:8px;
}

/* ================= BADGE ================= */
.badge{
    padding:6px 10px;
    border-radius:8px;
    font-size:12px;
}

.action-btn{
    padding:5px 10px;
    font-size:13px;
}

/* ================= MOBILE OPTIMIZATION ================= */
@media(max-width:768px){

    .page-wrapper{
        padding:15px;
    }

    .custom-card{
        padding:18px;
    }

    .table{
        font-size:13px;
    }

    .book-cover{
        width:45px;
        height:65px;
    }

    .action-btn{
        margin-bottom:4px;
    }

}

/* ================= ANIMATION ================= */
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

.custom-card{
    opacity:0;
    transform:translateY(15px);
    animation:cardFade .6s ease forwards;
}

.custom-card:nth-child(1){ animation-delay:.2s; }
.custom-card:nth-child(2){ animation-delay:.4s; }

@keyframes cardFade{
    to{
        opacity:1;
        transform:translateY(0);
    }
}

</style>

<h3 class="page-title">📚 Manajemen Data Buku</h3>

<!-- ================= FLASH MESSAGE ================= -->
<?php if($this->session->flashdata('success')){ ?>
<div class="position-fixed top-0 end-0 p-3" style="z-index:9999">
    <div class="toast show align-items-center text-white bg-success border-0">
        <div class="d-flex">
            <div class="toast-body">
                <?= $this->session->flashdata('success') ?>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto"
                data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>
<?php } ?>

<!-- ================= FORM TAMBAH ================= -->
<?php if($this->session->userdata('level')=='superadmin'){ ?>

<div class="custom-card">
<h5 class="section-title">Tambah Buku Baru</h5>

<form method="post" enctype="multipart/form-data"
action="<?= base_url('index.php/buku/tambah')?>">

<div class="row g-3">

<div class="col-lg-4 col-md-6">
<label class="form-label">Judul Buku</label>
<input name="judul" class="form-control" required>
</div>

<div class="col-lg-3 col-md-6">
<label class="form-label">Kategori</label>
<select name="kategori" class="form-select">
<?php foreach($kategori as $k){ ?>
<option value="<?= $k->id_kategori ?>">
<?= $k->nama_kategori ?>
</option>
<?php } ?>
</select>
</div>

<div class="col-lg-3 col-md-6">
<label class="form-label">Penulis</label>
<input name="penulis" class="form-control">
</div>

<div class="col-lg-2 col-md-6">
<label class="form-label">Tahun</label>
<input name="tahun" class="form-control">
</div>

<div class="col-lg-3 col-md-6">
<label class="form-label">Penerbit</label>
<input name="penerbit" class="form-control">
</div>

<div class="col-lg-2 col-md-4">
<label class="form-label">Stok</label>
<input name="stok" type="number" class="form-control" required>
</div>

<div class="col-lg-3 col-md-4">
<label class="form-label">Cover Buku</label>
<input type="file" name="gambar" class="form-control">
</div>

<div class="col-lg-4 col-md-4 d-grid align-items-end">
<button class="btn btn-success">
💾 Simpan Buku
</button>
</div>

</div>
</form>
</div>

<?php } ?>

<!-- ================= TABLE ================= -->
<div class="custom-card">
<h5 class="section-title">Daftar Buku</h5>

<div class="table-responsive">
<table class="table align-middle">

<thead>
<tr>
<th>No</th>
<th>Cover</th>
<th>Judul</th>
<th>Kategori</th>
<th>Penulis</th>
<th>Penerbit</th>
<th>Tahun</th>
<th>Stok</th>
<th>Dipinjam</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>

<?php if(!empty($buku)){ ?>
<?php $no=1; foreach($buku as $b){

$dip = $dipinjam[$b->id_buku] ?? 0;
$stok_tersedia = max(0, $b->stok - $dip);

?>

<tr>

<td><?= $no++ ?></td>

<td>
<img src="<?= base_url('uploads/'.(!empty($b->gambar)?$b->gambar:'default.png')) ?>"
class="book-cover">
</td>

<td><strong><?= $b->judul ?></strong></td>
<td><?= $b->nama_kategori ?></td>
<td><?= $b->penulis ?></td>
<td><?= $b->penerbit ?></td>
<td><?= $b->tahun ?></td>

<td>
<span class="badge bg-info text-dark">
<?= $stok_tersedia ?>
</span>
</td>

<td>
<a href="<?= base_url('index.php/buku/peminjam/'.$b->id_buku) ?>"
class="badge bg-warning text-dark text-decoration-none">
<?= $dip ?>
</a>
</td>

<td>
<?php if($this->session->userdata('level')=='superadmin'){ ?>

<div class="d-flex flex-wrap gap-1">
<a href="<?= base_url('index.php/buku/edit/'.$b->id_buku) ?>"
class="btn btn-primary btn-sm action-btn">
✏️
</a>

<a href="<?= base_url('index.php/buku/hapus/'.$b->id_buku) ?>"
onclick="return confirm('Hapus buku ini?')"
class="btn btn-danger btn-sm action-btn">
🗑️
</a>
</div>

<?php } else { ?>
<span class="badge bg-secondary">Read Only</span>
<?php } ?>
</td>

</tr>

<?php } ?>
<?php } else { ?>

<tr>
<td colspan="10" class="text-center text-muted py-4">
Belum ada data buku
</td>
</tr>

<?php } ?>

</tbody>
</table>
</div>

<!-- Pagination -->
<div class="mt-3">
<?= $pagination ?>
</div>

</div>

</div>

<?php $this->load->view('template/footer'); ?>