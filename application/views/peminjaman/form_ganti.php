<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/sidebar'); ?>

<h3 class="mb-3">Form Penggantian Buku</h3>

<!-- DATA BUKU -->
<div class="card shadow-sm mb-4">
<div class="card-header bg-danger text-white">
<strong>Buku yang Harus Diganti</strong>
</div>
<div class="card-body">

<table class="table table-bordered">
<tr>
<th width="200">Nama Anggota</th>
<td><?= $detail->nama ?></td>
</tr>
<tr>
<th>Buku Lama</th>
<td><?= $detail->judul ?></td>
</tr>
<tr>
<th>Jumlah</th>
<td><?= $detail->jumlah ?></td>
</tr>
<tr>
<th>Status</th>
<td>
<span class="badge bg-danger">
<?= ucfirst($detail->status) ?>
</span>
</td>
</tr>
</table>

</div>
</div>


<!-- FORM -->
<div class="card shadow-sm">
<div class="card-header bg-success text-white">
<strong>Input Buku Pengganti</strong>
</div>

<div class="card-body">

<form method="post" action="<?= base_url('index.php/peminjaman/simpan_ganti')?>">

<input type="hidden" name="id_detail" value="<?= $detail->id_detail ?>">

<!-- PILIH TIPE -->
<div class="mb-3">
<label class="form-label fw-bold">Metode Penggantian</label>

<select name="tipe" id="tipe" class="form-select" required>
<option value="">-- Pilih Metode --</option>
<option value="katalog">Gunakan Buku dari Katalog</option>
<option value="baru">Input Buku Baru</option>
</select>
</div>


<!-- PILIH DARI KATALOG -->
<div id="formKatalog" style="display:none">

<div class="mb-3">
<label class="form-label">Pilih Buku</label>
<select name="buku_katalog" class="form-select">

<option value="">-- Pilih Buku --</option>

<?php if(!empty($buku)){ ?>
<?php foreach($buku as $b){ ?>
<option value="<?= $b->id_buku ?>">
<?= $b->judul ?> — Stok: <?= $b->stok ?>
</option>
<?php } ?>
<?php } else { ?>
<option value="">Tidak ada buku</option>
<?php } ?>

</select>

</div>

</div>


<!-- INPUT BUKU BARU -->
<div id="formBaru" style="display:none">

<div class="mb-3">
<label class="form-label">Judul Buku</label>
<input name="judul" class="form-control" placeholder="Judul Buku">
</div>

<div class="mb-3">
<label class="form-label">Kategori</label>
<select name="kategori" class="form-select">
<?php foreach($kategori as $k){ ?>
<option value="<?= $k->id_kategori ?>">
<?= $k->nama_kategori ?>
</option>
<?php } ?>
</select>
</div>

<div class="mb-3">
<label class="form-label">Penulis</label>
<input name="penulis" class="form-control">
</div>

<div class="mb-3">
<label class="form-label">Penerbit</label>
<input name="penerbit" class="form-control">
</div>

<div class="mb-3">
<label class="form-label">Tahun</label>
<input name="tahun" type="number" class="form-control">
</div>

</div>


<div class="mt-3">
<button class="btn btn-success">
💾 Simpan Penggantian
</button>

<a href="<?= base_url('index.php/peminjaman')?>"
class="btn btn-secondary">
Kembali
</a>
</div>

</form>

</div>
</div>


<script>

const tipe = document.getElementById("tipe");
const katalog = document.getElementById("formKatalog");
const baru = document.getElementById("formBaru");

tipe.addEventListener("change",function(){

katalog.style.display="none";
baru.style.display="none";

if(this.value==="katalog") katalog.style.display="block";
if(this.value==="baru") baru.style.display="block";

});

</script>

<?php $this->load->view('template/footer'); ?>
