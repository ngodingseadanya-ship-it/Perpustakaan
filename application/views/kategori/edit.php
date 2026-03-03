<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/sidebar'); ?>

<h3>Edit Kategori</h3>

<form method="post" action="<?= base_url('index.php/kategori/update')?>">

<input type="hidden" name="id" value="<?= $row->id_kategori ?>">

<input class="form-control mb-2" name="nama_kategori" value="<?= $row->nama_kategori ?>">

<button class="btn btn-success">Update</button>
<a class="btn btn-secondary" href="<?= base_url('index.php/kategori')?>">Kembali</a>

</form>

<?php $this->load->view('template/footer'); ?>
