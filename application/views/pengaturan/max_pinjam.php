<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/sidebar'); ?>

<style>
.page-header{
    background:linear-gradient(135deg,#10b981,#059669);
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

.form-control{
    border-radius:10px;
}

.form-label{
    font-weight:600;
}

.input-group button{
    border-radius:0;
}

.info-box{
    background:#f0fdf4;
    border-left:4px solid #10b981;
    padding:12px 15px;
    border-radius:8px;
    font-size:14px;
    color:#444;
}
</style>

<div class="container-fluid">

<div class="page-header">
    <h4 class="mb-1">📚 Pengaturan Maksimal Peminjaman</h4>
    <small>Atur batas jumlah buku yang dapat dipinjam oleh setiap anggota</small>
</div>

<?php if($this->session->flashdata('success')){ ?>
<div class="alert alert-success alert-dismissible fade show shadow-sm">
<?= $this->session->flashdata('success') ?>
<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php } ?>

<div class="card setting-card">
<div class="card-body p-4">

<form method="post" action="<?= base_url('index.php/pengaturan/update_max_pinjam') ?>">

<div class="mb-4">

<label class="form-label">Maksimal Buku Dipinjam</label>

<div class="input-group" style="max-width:220px;">
<button type="button" class="btn btn-outline-secondary" onclick="kurang()">−</button>

<input type="number"
       id="maxInput"
       name="max"
       value="<?= $max ?>"
       class="form-control text-center"
       min="1"
       required>

<button type="button" class="btn btn-outline-secondary" onclick="tambah()">+</button>
</div>

<div class="text-muted small mt-2">
Jumlah maksimal buku yang boleh dipinjam anggota dalam satu waktu.
</div>

</div>

<div class="info-box mb-4">
Jika anggota telah mencapai batas maksimal, sistem akan otomatis menolak transaksi peminjaman baru.
</div>

<div class="text-end">
<a href="<?= base_url('index.php/pengaturan') ?>" 
   class="btn btn-light border px-4">
← Kembali
</a>

<button class="btn btn-success px-4">
💾 Simpan Perubahan
</button>
</div>

</form>

</div>
</div>

</div>

<script>
function tambah(){
    let input = document.getElementById('maxInput');
    input.value = parseInt(input.value || 0) + 1;
}

function kurang(){
    let input = document.getElementById('maxInput');
    if(parseInt(input.value) > 1){
        input.value = parseInt(input.value) - 1;
    }
}
</script>

<?php $this->load->view('template/footer'); ?>