<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/sidebar'); ?>

<h3>Monitoring Buku Harus Diganti</h3>

<div class="card shadow-sm">
<div class="card-body">

<table class="table table-bordered table-striped">

<thead class="table-dark">
<tr>
<th>No</th>
<th>Nama Anggota</th>
<th>Buku</th>
<th>Jumlah</th>
<th>Tanggal Pinjam</th>
<th>Status Buku</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>

<?php if(!empty($data)){ $no=1; foreach($data as $d){ ?>

<tr>

<td><?= $no++ ?></td>
<td><?= $d->nama ?></td>
<td><?= $d->judul ?></td>
<td><?= $d->jumlah ?></td>
<td><?= $d->tanggal_pinjam ?></td>

<td>
<span class="badge bg-danger">
<?= ucfirst($d->status) ?>
</span>
</td>

<td>
<a class="btn btn-success btn-sm"
   href="<?= base_url('index.php/peminjaman/form_ganti/'.$d->id_detail) ?>">
   Konfirmasi Ganti
</a>

</td>

</tr>

<?php }}else{ ?>

<tr>
<td colspan="7" align="center">Tidak ada buku yang harus diganti</td>
</tr>

<?php } ?>

</tbody>
</table>

</div>
</div>

<?php $this->load->view('template/footer'); ?>
