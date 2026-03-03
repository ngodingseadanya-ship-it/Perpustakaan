<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/sidebar'); ?>

<style>
.edit-card{
    background:#fff;
    padding:30px;
    border-radius:15px;
    box-shadow:0 8px 25px rgba(0,0,0,.06);
    max-width:700px;
    margin:auto;
}
</style>

<h3 class="mb-4 fw-bold">✏️ Edit Anggota</h3>

<div class="edit-card">

<form method="post" action="<?= base_url('index.php/anggota/update') ?>">

<input type="hidden" name="id" value="<?= $row->id_anggota ?>">

<div class="mb-3">
<label>NIS</label>
<input type="text" name="nis" class="form-control" value="<?= $row->nis ?>" required>
</div>

<div class="mb-3">
<label>Nama</label>
<input type="text" name="nama" class="form-control" value="<?= $row->nama ?>" required>
</div>

<div class="mb-3">
<label>Kelas</label>
<input type="text" name="kelas" class="form-control" value="<?= $row->kelas ?>">
</div>

<div class="mb-3">
<label>Alamat</label>
<textarea name="alamat" class="form-control"><?= $row->alamat ?></textarea>
</div>

<div class="mb-3">
<label>No WhatsApp</label>
<input type="text" name="no_hp" class="form-control" value="<?= $row->no_hp ?>">
</div>

<div class="d-flex justify-content-between">
<a href="<?= base_url('index.php/anggota') ?>" class="btn btn-secondary">
Kembali
</a>

<button class="btn btn-primary">
Update Data
</button>
</div>

</form>
</div>

<?php $this->load->view('template/footer'); ?>
