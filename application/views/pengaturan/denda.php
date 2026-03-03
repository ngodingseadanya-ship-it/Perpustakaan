<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/sidebar'); ?>

<style>
.page-header{
    background:linear-gradient(135deg,#f59e0b,#f97316);
    padding:25px 30px;
    border-radius:18px;
    color:#fff;
    margin-bottom:25px;
    box-shadow:0 15px 35px rgba(0,0,0,.15);
}

.setting-card{
    border:none;
    border-radius:18px;
    box-shadow:0 8px 25px rgba(0,0,0,.08);
    background:#fff;
}

.form-switch .form-check-input{
    width:55px;
    height:28px;
    cursor:pointer;
}

.form-switch .form-check-input:checked{
    background-color:#16a34a;
    border-color:#16a34a;
}

.input-group-text{
    background:#f3f4f6;
    border:none;
    font-weight:600;
}

.form-control{
    border-radius:10px;
}

.form-label{
    font-weight:600;
}

.info-box{
    background:#f8fafc;
    border-left:4px solid #f59e0b;
    padding:12px 15px;
    border-radius:8px;
    font-size:14px;
    color:#555;
}
</style>

<div class="container-fluid">

<div class="page-header">
    <h4 class="mb-1">💰 Pengaturan Denda</h4>
    <small>Kelola sistem denda keterlambatan pengembalian buku</small>
</div>

<?php if($this->session->flashdata('warning')){ ?>
<div class="alert alert-warning alert-dismissible fade show shadow-sm">
<?= $this->session->flashdata('warning') ?>
<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php } ?>

<?php if($this->session->flashdata('success')){ ?>
<div class="alert alert-success alert-dismissible fade show shadow-sm">
<?= $this->session->flashdata('success') ?>
<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php } ?>

<div class="card setting-card">
<div class="card-body p-4">

<form method="post" action="<?= base_url('index.php/pengaturan/update_denda') ?>">

<!-- STATUS DENDA -->
<div class="mb-4 d-flex justify-content-between align-items-center">

<div>
<label class="form-label mb-1">Status Denda</label>
<div class="text-muted small">
Aktifkan atau nonaktifkan sistem denda keterlambatan
</div>
</div>

<div class="form-check form-switch">
<input class="form-check-input"
       type="checkbox"
       name="status"
       value="on"
       <?= $status=='on'?'checked':'' ?>>
</div>

</div>

<hr>

<!-- NOMINAL DENDA -->
<div class="mb-4">

<label class="form-label">Denda per Hari</label>

<div class="input-group">
<span class="input-group-text">Rp</span>
<input type="number"
       name="nominal"
       value="<?= $nominal ?>"
       class="form-control"
       min="0"
       step="1000"
       required>
</div>

<div class="text-muted small mt-2">
Masukkan nominal dalam kelipatan Rp 1.000
</div>

</div>

<div class="info-box mb-4">
Sistem akan menghitung denda otomatis berdasarkan jumlah hari keterlambatan
dan nominal per hari yang ditentukan di atas.
</div>

<div class="text-end">
<a href="<?= base_url('index.php/pengaturan') ?>" 
   class="btn btn-light border px-4">
← Kembali
</a>

<button class="btn btn-primary px-4">
💾 Simpan Perubahan
</button>
</div>

</form>

</div>
</div>

</div>

<?php $this->load->view('template/footer'); ?>