<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
body{ font-family: DejaVu Sans; font-size:12px; }
table{ width:100%; border-collapse:collapse; margin-top:20px;}
th,td{ border:1px solid #000; padding:6px; text-align:left;}
th{ background:#eee; }
.title{ text-align:center; font-size:18px; margin-bottom:10px;}
</style>
</head>
<body>

<div class="title">
LAPORAN DENDA PERPUSTAKAAN
</div>

<table>
<tr>
<th>No</th>
<th>Nama</th>
<th>Buku</th>
<th>Denda</th>
<th>Status</th>
<th>Tgl Bayar</th>
</tr>

<?php $no=1; $total=0; foreach($data as $d){
$total+=$d->denda; ?>

<tr>
<td><?= $no++ ?></td>
<td><?= $d->nama ?></td>
<td><?= $d->judul ?></td>
<td>Rp <?= number_format($d->denda) ?></td>
<td><?= $d->status_bayar ?></td>
<td><?= $d->tanggal_bayar ?: '-' ?></td>
</tr>

<?php } ?>

<tr>
<th colspan="3">TOTAL</th>
<th colspan="3">Rp <?= number_format($total) ?></th>
</tr>

</table>

</body>
</html>