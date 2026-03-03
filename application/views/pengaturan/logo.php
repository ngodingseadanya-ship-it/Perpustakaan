<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/sidebar'); ?>

<div class="container-fluid">

<h4 class="mb-4">Pengaturan Logo</h4>

<?php if($this->session->flashdata('error')){ ?>
<div class="alert alert-danger">
<?= $this->session->flashdata('error') ?>
</div>
<?php } ?>

<?php if($this->session->flashdata('success')){ ?>
<div class="alert alert-success">
<?= $this->session->flashdata('success') ?>
</div>
<?php } ?>

<div class="card p-4" style="max-width:500px">

<h6>Logo Saat Ini</h6>
<img src="<?= base_url('assets/logo/'.$logo) ?>" width="150" class="mb-3">

<form action="<?= base_url('index.php/pengaturan/upload_logo') ?>" method="post" enctype="multipart/form-data">

<div class="mb-3">
<label class="form-label">Upload Logo Baru</label>
<input type="file" name="logo" class="form-control" required>
</div>

<button class="btn btn-primary">Simpan Logo</button>

</form>

</div>

</div>

<?php $this->load->view('template/footer'); ?>