<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/sidebar_anggota'); ?>

<style>
/* WRAPPER COVER */
.book-cover-wrap {
    height: 240px;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
}

/* GAMBAR */
.book-cover-img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    transition: transform .3s ease;
}

.book-card:hover .book-cover-img {
    transform: scale(1.05);
}

/* OVERLAY JUDUL */
.cover-title {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;

    padding: 10px 12px;

    /* background lebih gelap & konsisten */
    background: rgba(0, 0, 0, 0.75);

    color: #fff;
    font-size: 14px;
    font-weight: 600;
    text-align: center;

    /* bikin teks makin kebaca */
    text-shadow: 0 2px 4px rgba(0,0,0,.8);

    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}


</style>


<h3 class="mb-4">📚 Katalog Buku</h3>

<div class="row">

<?php if(!empty($buku)){ ?>
<?php foreach($buku as $b){ ?>

<div class="col-lg-3 col-md-4 col-sm-6 mb-4">

<div class="card book-card h-100">

<div class="position-relative">
<div class="book-cover-wrap">
    <img 
        src="<?= base_url('uploads/'.($b->gambar ? $b->gambar : 'default.png')) ?>"
        class="book-cover-img"
        alt="<?= $b->judul ?>"
    >

    <div class="cover-title">
        <?= $b->judul ?>
    </div>
</div>



<?php if($b->stok > 0){ ?>
<span class="badge bg-success badge-stok">
Stok <?= $b->stok ?>
</span>
<?php }else{ ?>
<span class="badge bg-danger badge-stok">
Habis
</span>
<?php } ?>
</div>

<div class="card-body d-flex flex-column">

<div class="book-title mb-2">
<?= $b->judul ?>
</div>

<div class="mt-auto">

<?php if($b->stok > 0){ ?>
<a 
  href="<?= base_url('index.php/anggota_area/favorit/'.$b->id_buku) ?>"
  class="btn btn-outline-danger btn-sm w-100">
  ❤️ Tambah Favorit
</a>
<?php }else{ ?>
<button class="btn btn-secondary btn-sm w-100" disabled>
Tidak Tersedia
</button>
<?php } ?>

</div>

</div>
</div>
</div>

<?php } ?>
<?php }else{ ?>

<div class="col-12 text-center text-muted">
📕 Belum ada buku tersedia
</div>

<?php } ?>

</div>

<?php $this->load->view('template/footer'); ?>
