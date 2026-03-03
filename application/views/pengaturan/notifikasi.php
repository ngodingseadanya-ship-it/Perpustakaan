<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/sidebar'); ?>

<style>
body{
    background:linear-gradient(135deg,#eef2f7,#f8fafc);
}

/* ===== HEADER ===== */
.page-header{
    background:linear-gradient(135deg,#3b82f6,#6366f1);
    padding:25px 30px;
    border-radius:18px;
    color:#fff;
    margin-bottom:25px;
    box-shadow:0 15px 35px rgba(0,0,0,.15);
}

.setting-card{
    border:none;
    border-radius:18px;
    box-shadow:0 10px 30px rgba(0,0,0,.08);
    background:#fff;
}

.form-label{
    font-weight:600;
}

.form-control{
    border-radius:10px;
}

.input-group button{
    border-radius:0;
}

.info-box{
    background:#eef2ff;
    border-left:4px solid #6366f1;
    padding:14px 16px;
    border-radius:10px;
    font-size:14px;
    color:#374151;
}

.btn{
    border-radius:10px;
    padding:8px 20px;
}
</style>

<div class="container-fluid">

<!-- HEADER -->
<div class="page-header">
    <h4 class="mb-1">🔔 Pengaturan Notifikasi</h4>
    <small>Atur sistem pengingat sebelum jatuh tempo pengembalian buku</small>
</div>

<?php if($this->session->flashdata('success')){ ?>
<div class="alert alert-success alert-dismissible fade show shadow-sm">
    <?= $this->session->flashdata('success') ?>
    <button class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php } ?>

<?php if($this->session->flashdata('error')){ ?>
<div class="alert alert-danger alert-dismissible fade show shadow-sm">
    <?= $this->session->flashdata('error') ?>
    <button class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php } ?>

<div class="card setting-card">
<div class="card-body p-4">

<form method="post" action="<?= base_url('index.php/pengaturan/update_notifikasi') ?>">

<div class="mb-4">

<label class="form-label">Notifikasi Sebelum Jatuh Tempo</label>

<div class="input-group" style="max-width:260px;">
    <button type="button" class="btn btn-outline-secondary" onclick="kurang()">−</button>

    <input type="number"
           id="notifInput"
           name="notif_hari"
           value="<?= $notif_hari ?>"
           class="form-control text-center"
           min="1"
           required>

    <button type="button" class="btn btn-outline-secondary" onclick="tambah()">+</button>

    <span class="input-group-text">Hari</span>
</div>

<div class="text-muted small mt-2">
Jumlah hari sebelum jatuh tempo sistem akan mengirim pengingat.
</div>

</div>

<div class="info-box mb-4">
💡 Sistem akan mengirim notifikasi otomatis kepada peminjam beberapa hari sebelum batas pengembalian buku.  
Contoh: jika diisi <b>7</b>, maka notifikasi dikirim 7 hari sebelum tanggal jatuh tempo.
</div>

<div class="text-end">
<a href="<?= base_url('index.php/pengaturan') ?>" 
   class="btn btn-light border px-4">
← Kembali
</a>

<button type="submit" class="btn btn-primary px-4">
💾 Simpan Pengaturan
</button>
</div>

</form>

</div>
</div>

</div>

<script>
function tambah(){
    let input = document.getElementById('notifInput');
    input.value = parseInt(input.value || 0) + 1;
}

function kurang(){
    let input = document.getElementById('notifInput');
    if(parseInt(input.value) > 1){
        input.value = parseInt(input.value) - 1;
    }
}
</script>

<?php $this->load->view('template/footer'); ?>