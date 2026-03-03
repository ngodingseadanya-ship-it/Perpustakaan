<!DOCTYPE html>
<html>
<head>
<title>Laporan Peminjaman Buku</title>

<style>
body{
    font-family:"Times New Roman", serif;
    margin:40px;
    color:#000;
}

.header{
    text-align:center;
    line-height:1.4;
}

.header h1{
    margin:0;
    font-size:20px;
    letter-spacing:2px;
}

.header h2{
    margin:0;
    font-size:16px;
    font-weight:normal;
}

.header p{
    margin:2px 0;
    font-size:13px;
}

.line{
    border-top:3px solid #000;
    border-bottom:1px solid #000;
    margin:15px 0 25px 0;
}

.info{
    margin-bottom:15px;
    font-size:14px;
}

table{
    width:100%;
    border-collapse:collapse;
    font-size:13px;
}

th, td{
    border:1px solid #000;
    padding:6px;
}

th{
    background:#dcdcdc;
    text-align:center;
    font-weight:bold;
}

td{
    vertical-align:middle;
}

.center{
    text-align:center;
}

.right{
    text-align:right;
}

.status-dipinjam{
    color:#b8860b;
    font-weight:bold;
}

.status-dikembalikan{
    color:#006400;
    font-weight:bold;
}

.status-rusak,
.status-hilang{
    color:#8b0000;
    font-weight:bold;
}

.footer{
    margin-top:20px;
    font-size:14px;
}

.signature{
    width:250px;
    float:right;
    text-align:center;
    margin-top:60px;
}
</style>

</head>
<body>

<div class="header">
<h1>SISTEM INFORMASI PERPUSTAKAAN</h1>
<h2>LAPORAN PEMINJAMAN BUKU</h2>
<p>Dicetak pada: <?= date('d F Y') ?></p>
</div>

<div class="line"></div>

<div class="info">
<b>Total Data :</b> <?= count($data) ?>
</div>

<table>
<tr>
<th width="5%">No</th>
<th>Nama Anggota</th>
<th>Judul Buku</th>
<th width="8%">Jumlah</th>
<th width="12%">Tgl Pinjam</th>
<th width="12%">Jatuh Tempo</th>
<th width="14%">Tgl Dikembalikan</th>
<th width="10%">Status</th>
</tr>

<?php if(!empty($data)){ $no=1; foreach($data as $d){

$status = strtolower($d->status ?? 'dipinjam');
$class = '';

if($status == 'dipinjam'){
    $class = 'status-dipinjam';
}elseif($status == 'dikembalikan'){
    $class = 'status-dikembalikan';
}elseif($status == 'rusak'){
    $class = 'status-rusak';
}elseif($status == 'hilang'){
    $class = 'status-hilang';
}
?>

<tr>
<td class="center"><?= $no++ ?></td>
<td><?= $d->nama ?></td>
<td><?= $d->judul ?></td>
<td class="center"><?= $d->jumlah ?></td>
<td class="center"><?= date('d-m-Y', strtotime($d->tanggal_pinjam)) ?></td>
<td class="center"><?= date('d-m-Y', strtotime($d->tanggal_kembali)) ?></td>
<td class="center">
<?= $d->tanggal_dikembalikan ? date('d-m-Y', strtotime($d->tanggal_dikembalikan)) : '-' ?>
</td>
<td class="center <?= $class ?>">
<?= ucfirst($status) ?>
</td>
</tr>

<?php }} else { ?>

<tr>
<td colspan="8" class="center">Tidak ada data</td>
</tr>

<?php } ?>
</table>

<div class="signature">
Mengetahui,<br>
Petugas Perpustakaan
<br><br><br><br>
____________________
</div>

</body>
</html>