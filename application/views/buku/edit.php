<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/sidebar'); ?>

<h3>Edit Buku</h3>

<form method="post" action="<?= base_url('index.php/buku/update')?>"
      enctype="multipart/form-data">

<input type="hidden" name="id" value="<?= $row->id_buku ?>">

<!-- COVER LAMA -->
<?php if(!empty($row->gambar)){ ?>
<div class="mb-3">
<label>Cover Saat Ini</label><br>
<img src="<?= base_url('uploads/'.$row->gambar) ?>"
     style="height:150px;border-radius:8px;border:1px solid #ddd;padding:4px">
</div>
<?php } ?>

<!-- UPLOAD COVER BARU -->
<div class="mb-3">
<label>Upload Cover Baru</label>
<input type="file" name="cover" id="coverInput"
class="form-control" accept="image/*">

<small class="text-muted">
Kosongkan jika tidak ingin mengganti cover
</small>

<!-- PREVIEW -->
<div class="mt-2">
<img id="previewCover"
style="display:none;height:150px;border-radius:8px;border:1px solid #ddd;padding:4px">
</div>
</div>

<!-- KATEGORI -->
<select name="kategori" class="form-control mb-2">
<?php foreach($kategori as $k){ ?>
<option value="<?= $k->id_kategori ?>"
<?= $row->id_kategori==$k->id_kategori?'selected':'' ?>>
<?= $k->nama_kategori ?>
</option>
<?php } ?>
</select>

<!-- INPUT DATA -->
<input class="form-control mb-2" name="judul"
value="<?= $row->judul ?>" placeholder="Judul Buku">

<input class="form-control mb-2" name="penulis"
value="<?= $row->penulis ?>" placeholder="Penulis">

<input class="form-control mb-2" name="penerbit"
value="<?= $row->penerbit ?>" placeholder="Penerbit">

<input class="form-control mb-2" name="tahun"
value="<?= $row->tahun ?>" placeholder="Tahun">

<input class="form-control mb-2" name="stok"
value="<?= $row->stok ?>" placeholder="Stok">

<!-- BUTTON -->
<button class="btn btn-success">Update</button>
<a class="btn btn-secondary" href="<?= base_url('index.php/buku')?>">Kembali</a>

</form>


<!-- SCRIPT PREVIEW GAMBAR -->
<script>
document.getElementById('coverInput').addEventListener('change',function(e){

const file = e.target.files[0];
const preview = document.getElementById('previewCover');

if(file){

preview.src = URL.createObjectURL(file);
preview.style.display = 'block';

}else{

preview.style.display = 'none';

}

});
</script>

<?php $this->load->view('template/footer'); ?>
