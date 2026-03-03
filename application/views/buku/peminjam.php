<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/sidebar'); ?>

<div class="container-fluid">

<h4 class="mb-4">
📖 Daftar Peminjam Buku  
<b><?= $buku->judul ?></b>
</h4>

<div class="card shadow-sm">
<div class="card-body">

<div class="table-responsive">
<table class="table table-bordered table-striped">

<thead class="table-dark">
<tr>
<th>No</th>
<th>NIS</th>
<th>Nama</th>
<th>Kelas</th>
<th>Jumlah</th>
<th>Tgl Pinjam</th>
<th>Jatuh Tempo</th>
<th>Status</th>
</tr>
</thead>

<tbody>

<?php if(!empty($list)){ $no=1; foreach($list as $l){ ?>

<?php
$badge=[
'dipinjam'=>'warning',
'dikembalikan'=>'success',
'rusak'=>'danger',
'hilang'=>'dark'
];
?>

<tr>
<td><?= $no++ ?></td>
<td><?= $l->nis ?></td>
<td><?= $l->nama ?></td>
<td><?= $l->kelas ?></td>
<td><?= $l->jumlah ?></td>
<td><?= $l->tanggal_pinjam ?></td>
<td><?= $l->tanggal_kembali ?></td>
<td>
<span class="badge bg-<?= $badge[$l->status] ?>">
<?= ucfirst($l->status) ?>
</span>
</td>
</tr>

<?php }} else { ?>

<tr>
<td colspan="8" class="text-center text-muted">
Tidak ada peminjam
</td>
</tr>

<?php } ?>

</tbody>
</table>
</div>
<hr class="my-5">

<h5>📚 Riwayat Peminjaman</h5>

<div class="table-responsive">
<table class="table table-bordered table-striped">

<thead class="table-secondary">
<tr>
<th>No</th>
<th>NIS</th>
<th>Nama</th>
<th>Kelas</th>
<th>Jumlah</th>
<th>Tgl Pinjam</th>
<th>Tgl Kembali</th>
<th>Status</th>
</tr>
</thead>

<tbody>

<?php if(!empty($riwayat)){ $no=1; foreach($riwayat as $r){ ?>

<tr>
<td><?= $no++ ?></td>
<td><?= $r->nis ?></td>
<td><?= $r->nama ?></td>
<td><?= $r->kelas ?></td>
<td><?= $r->jumlah ?></td>
<td><?= $r->tanggal_pinjam ?></td>
<td><?= $r->tanggal_kembali ?></td>
<td>
<span class="badge bg-secondary">
<?= ucfirst($r->status) ?>
</span>
</td>
</tr>

<?php }} else { ?>

<tr>
<td colspan="8" class="text-center text-muted">
Belum ada riwayat peminjaman
</td>
</tr>

<?php } ?>

</tbody>
</table>
</div>
<a href="<?= base_url('index.php/buku') ?>" class="btn btn-secondary mt-3">
⬅ Kembali
</a>

</div>
</div>

</div>

<?php $this->load->view('template/footer'); ?>
