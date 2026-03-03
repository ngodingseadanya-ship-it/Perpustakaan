<?php $this->load->view('template/header'); ?>

<?php $this->load->view('template/sidebar'); ?>
<style>
body{
    background:#f4f6f9;
}

.page-title{
    font-weight:600;
    margin:20px 0;
}

.custom-card{
    background:#fff;
    border-radius:15px;
    box-shadow:0 8px 25px rgba(0,0,0,.06);
    padding:20px;
}

.table thead{
    background:linear-gradient(90deg,#0d6efd,#4e73df);
    color:#fff;
}

.rank-1{ background:#fff3cd !important; }
.rank-2{ background:#e2e3e5 !important; }
.rank-3{ background:#f8d7da !important; }

.trophy{
    font-size:20px;
}
</style>

<div class="container-fluid">

<h3 class="page-title">🏆 Ranking Pengunjung Teraktif</h3>

<div class="custom-card">

<div class="table-responsive">
<table class="table table-hover align-middle">

<thead>
<tr>
<th width="80">Rank</th>
<th>Nama Pengunjung</th>
<th width="150">Total Kunjungan</th>
</tr>
</thead>

<tbody>

<?php if(!empty($ranking)){ ?>
<?php $no=1; foreach($ranking as $r){ ?>

<tr class="
<?php
if($no==1) echo 'rank-1';
elseif($no==2) echo 'rank-2';
elseif($no==3) echo 'rank-3';
?>
">

<td class="text-center">
<?php if($no==1){ ?>
🥇
<?php }elseif($no==2){ ?>
🥈
<?php }elseif($no==3){ ?>
🥉
<?php }else{ ?>
<?= $no ?>
<?php } ?>
</td>

<td><?= $r->nama_pengunjung ?></td>

<td class="text-center">
<span class="badge bg-primary">
<?= $r->total_kunjungan ?>
</span>
</td>

</tr>

<?php $no++; } ?>
<?php } else { ?>

<tr>
<td colspan="3" class="text-center text-muted">
Belum ada data
</td>
</tr>

<?php } ?>

</tbody>
</table>
</div>

</div>

<div class="mt-3">
    <a href="<?= base_url('index.php/pengunjung') ?>" class="btn btn-secondary">
        ← Kembali
    </a>
</div>

</div>

<?php $this->load->view('template/footer'); ?>
