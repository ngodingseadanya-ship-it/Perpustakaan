<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/sidebar'); ?>

<style>
body{
    background:linear-gradient(135deg,#eef2f7,#f8fafc);
}

/* Header */
.page-header{
    background:linear-gradient(135deg,#3b82f6,#6366f1);
    padding:35px;
    border-radius:20px;
    color:#fff;
    margin-bottom:35px;
    box-shadow:0 15px 35px rgba(0,0,0,0.15);
}

.page-header h4{
    font-weight:700;
    margin-bottom:5px;
}

.page-header p{
    opacity:.9;
    margin:0;
}

/* Card */
.setting-card{
    border:none;
    border-radius:20px;
    transition:all .3s ease;
    background:#fff;
    position:relative;
    overflow:hidden;
}

.setting-card:hover{
    transform:translateY(-8px);
    box-shadow:0 20px 40px rgba(0,0,0,0.15);
}

.setting-card::before{
    content:"";
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:4px;
    background:linear-gradient(90deg,#3b82f6,#6366f1);
}

/* Icon */
.icon-circle{
    width:75px;
    height:75px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:30px;
    margin:auto;
    margin-bottom:18px;
    transition:.3s;
}

.setting-card:hover .icon-circle{
    transform:scale(1.1);
}

/* Soft Backgrounds */
.bg-soft-primary{ background:#e0edff; color:#2563eb; }
.bg-soft-warning{ background:#fff4e5; color:#f59e0b; }
.bg-soft-success{ background:#e9fbf0; color:#10b981; }
.bg-soft-danger{ background:#ffeaea; color:#ef4444; }

/* Section Title */
.section-title{
    font-weight:600;
    margin-bottom:20px;
    color:#374151;
    border-left:4px solid #6366f1;
    padding-left:10px;
}

/* Text */
.setting-card h5{
    font-weight:600;
}

.setting-card small{
    color:#6b7280;
}
</style>

<div class="container-fluid">

<!-- HEADER -->
<div class="page-header">
    <h4>⚙ Pusat Pengaturan Sistem</h4>
    <p>Kelola konfigurasi utama sistem informasi perpustakaan Anda</p>
</div>

<!-- ============================= -->
<!-- PENGATURAN UMUM -->
<!-- ============================= -->
<h6 class="section-title">Pengaturan Sistem</h6>
<div class="row g-4 mb-4">

    <!-- Logo -->
    <div class="col-lg-4 col-md-6">
        <a href="<?= base_url('index.php/pengaturan/logo') ?>" class="text-decoration-none">
            <div class="card setting-card text-center p-4">
                <div class="icon-circle bg-soft-primary">🖼</div>
                <h5 class="mb-1">Pengaturan Logo</h5>
                <small>Ubah logo aplikasi perpustakaan</small>
            </div>
        </a>
    </div>
<!-- Pengaturan Sidebar -->
<div class="col-lg-4 col-md-6">
    <a href="<?= base_url('index.php/pengaturan/sidebar') ?>" class="text-decoration-none">
        <div class="card setting-card text-center p-4">
            <div class="icon-circle bg-soft-success">🧩</div>
            <h5 class="mb-1">Pengaturan Sidebar</h5>
            <small>Atur menu apa saja yang tampil di sidebar</small>
        </div>
    </a>
</div>
</div>

<!-- ============================= -->
<!-- PENGATURAN PEMINJAMAN -->
<!-- ============================= -->
<h6 class="section-title">Pengaturan Peminjaman</h6>
<div class="row g-4">

    <!-- Lama Pinjam -->
    <div class="col-lg-4 col-md-6">
        <a href="<?= base_url('index.php/pengaturan/lama_pinjam') ?>" class="text-decoration-none">
            <div class="card setting-card text-center p-4">
                <div class="icon-circle bg-soft-primary">📅</div>
                <h5 class="mb-1">Lama Peminjaman</h5>
                <small>Atur durasi peminjaman buku</small>
            </div>
        </a>
    </div>

    <!-- Denda -->
    <div class="col-lg-4 col-md-6">
        <a href="<?= base_url('index.php/pengaturan/denda') ?>" class="text-decoration-none">
            <div class="card setting-card text-center p-4">
                <div class="icon-circle bg-soft-warning">💰</div>
                <h5 class="mb-1">Pengaturan Denda</h5>
                <small>Atur sistem denda keterlambatan</small>
            </div>
        </a>
    </div>

    <!-- Maksimal -->
    <div class="col-lg-4 col-md-6">
        <a href="<?= base_url('index.php/pengaturan/max_pinjam') ?>" class="text-decoration-none">
            <div class="card setting-card text-center p-4">
                <div class="icon-circle bg-soft-success">📚</div>
                <h5 class="mb-1">Maksimal Peminjaman</h5>
                <small>Atur batas jumlah buku dipinjam</small>
            </div>
        </a>
    </div>

    <!-- Notifikasi -->
    <div class="col-lg-4 col-md-6">
        <a href="<?= base_url('index.php/pengaturan/notifikasi') ?>" class="text-decoration-none">
            <div class="card setting-card text-center p-4">
                <div class="icon-circle bg-soft-danger">🔔</div>
                <h5 class="mb-1">Pengaturan Notifikasi</h5>
                <small>Atur sistem pemberitahuan</small>
            </div>
        </a>
    </div>

</div>

</div>

<?php $this->load->view('template/footer'); ?>