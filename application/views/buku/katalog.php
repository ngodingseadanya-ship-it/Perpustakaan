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

/* ================= FILTER CARD ================= */
.filter-card{
    background:#fff;
    border-radius:18px;
    padding:20px;
    box-shadow:0 4px 18px rgba(0,0,0,0.05);
    margin-bottom:30px;
}

/* ================= FORM ================= */
.form-control, .form-select{
    border-radius:12px;
    padding:10px 14px;
}

.btn{
    border-radius:12px;
    font-weight:600;
}

/* ================= BOOK CARD ================= */
.book-card{
    border:none;
    border-radius:18px;
    transition:.25s ease;
    background:#fff;
    box-shadow:0 3px 14px rgba(0,0,0,0.06);
    overflow:hidden;
}

.book-card:hover{
    transform:translateY(-6px);
    box-shadow:0 10px 25px rgba(0,0,0,0.12);
}

/* ================= COVER ================= */
.book-cover{
    height:240px;
    object-fit:contain;
    padding:15px;
    background:#f8fafc;
}

/* ================= TITLE ================= */
.book-title{
    font-weight:600;
    min-height:48px;
    font-size:15px;
}

/* ================= BADGE ================= */
.badge{
    font-size:12px;
    padding:6px 10px;
    border-radius:8px;
}

/* ================= SECTION TITLE ================= */
.section-title{
    font-weight:600;
    margin-bottom:20px;
    color:#34495e;
}

/* ================= MOBILE ================= */
@media(max-width:768px){

    .book-cover{
        height:200px;
    }

    .filter-card{
        padding:18px;
    }

    .book-title{
        font-size:14px;
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

</style>


<h3 class="page-title">📚 Katalog Buku</h3>


<!-- ================= FILTER ================= -->
<div class="filter-card">

<form method="get" action="<?= base_url('index.php/buku/katalog') ?>">

<div class="row g-3 align-items-end">

<!-- SEARCH -->
<div class="col-lg-5 col-md-6 col-12">
<label class="form-label fw-semibold">Cari Buku</label>
<input type="text" name="q" class="form-control"
placeholder="🔎 Cari judul atau penulis..."
value="<?= $this->input->get('q') ?>">
</div>

<!-- KATEGORI -->
<div class="col-lg-3 col-md-6 col-12">
<label class="form-label fw-semibold">Kategori</label>
<select name="kategori" id="kategoriFilter" class="form-select">
<option value="">Semua Kategori</option>
<?php foreach($kategori as $k){ ?>
<option value="<?= $k->id_kategori ?>"
<?= $this->input->get('kategori')==$k->id_kategori?'selected':'' ?>>
<?= $k->nama_kategori ?>
</option>
<?php } ?>
</select>
</div>

<!-- SORT -->
<div class="col-lg-2 col-md-6 col-12">
<label class="form-label fw-semibold">Urutkan</label>
<select name="sort" id="sortFilter" class="form-select">
<option value="">Terbaru</option>
<option value="terlama" <?= $this->input->get('sort')=='terlama'?'selected':'' ?>>Terlama</option>
<option value="judul_asc" <?= $this->input->get('sort')=='judul_asc'?'selected':'' ?>>Judul A-Z</option>
<option value="judul_desc" <?= $this->input->get('sort')=='judul_desc'?'selected':'' ?>>Judul Z-A</option>
</select>
</div>

<!-- BUTTON -->
<div class="col-lg-2 col-md-6 col-12 d-grid">
<button class="btn btn-primary">
Cari Buku
</button>
</div>

</div>
</form>
</div>


<!-- ================= KATALOG ================= -->
<h5 class="section-title">Daftar Buku</h5>

<div class="row">

<?php if(!empty($buku)){ ?>
<?php foreach($buku as $b){ ?>

<?php
$dip = $dipinjam[$b->id_buku] ?? 0;
$stok_tersedia = max(0, $b->stok - $dip);
?>

<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">

<div class="card book-card h-100 text-center">

<img src="<?= base_url('uploads/'.(!empty($b->gambar)?$b->gambar:'default.png')) ?>"
class="book-cover img-fluid">

<div class="card-body d-flex flex-column">

<div class="book-title mb-2">
<?= $b->judul ?>
</div>

<small class="text-muted mb-3">
<?= $b->nama_kategori ?>
</small>

<div class="mt-auto">

<?php if($stok_tersedia > 0){ ?>

<span class="badge bg-success mb-2">
📦 Stok: <?= $stok_tersedia ?>
</span>

<br>

<a href="<?= base_url('index.php/buku/peminjam/'.$b->id_buku) ?>"
class="badge bg-warning text-dark text-decoration-none">
📚 Dipinjam: <?= $dip ?>
</a>

<?php } else { ?>

<span class="badge bg-danger">
Stok Habis
</span>

<?php } ?>

</div>

</div>
</div>

</div>

<?php } ?>
<?php } else { ?>

<div class="col-12 text-center text-muted mt-4">
Tidak ada buku ditemukan
</div>

<?php } ?>

</div>

<!-- Pagination -->
<?php if(isset($pagination)){ ?>
<div class="mt-4">
<?= $pagination ?>
</div>
<?php } ?>

</div>


<script>
document.querySelectorAll("#kategoriFilter, #sortFilter")
.forEach(el=>{
    el.addEventListener("change", ()=> el.form.submit());
});
</script>

<?php $this->load->view('template/footer'); ?>