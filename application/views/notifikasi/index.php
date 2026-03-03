<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/sidebar'); ?>
<div class="page-wrapper">
<style>
.page-title {
    font-weight: 600;
    margin-bottom: 20px;
}

.card-custom {
    border-radius: 12px;
    box-shadow: 0 6px 18px rgba(0,0,0,.08);
    border: none;
}

.table thead {
    background: #263238;
    color: #fff;
}

.table tbody tr:hover {
    background: #f5f5f5;
}

.status-terlambat { background: #f8d7da !important; }
.status-h1        { background: #ffe5e5 !important; }
.status-h2        { background: #fff3cd !important; }
.status-h3        { background: #e2e3ff !important; }
/* ===== PAGE LOAD ANIMATION ===== */

.page-wrapper{
    opacity:0;
    transform:translateY(20px);
    animation:pageFade .6s ease forwards;
}

@keyframes pageFade{
    to{
        opacity:1;
        transform:translateY(0);
    }
}

/* CARD ANIMATION */
.custom-card{
    opacity:0;
    transform:translateY(15px);
    animation:cardFade .6s ease forwards;
}

.custom-card:nth-child(1){
    animation-delay:.2s;
}
.custom-card:nth-child(2){
    animation-delay:.4s;
}

@keyframes cardFade{
    to{
        opacity:1;
        transform:translateY(0);
    }
}

/* TABLE ROW FADE */
.table tbody tr{
    opacity:0;
    transform:translateY(10px);
    animation:rowFade .4s ease forwards;
}

.table tbody tr:nth-child(odd){
    animation-delay:.1s;
}
.table tbody tr:nth-child(even){
    animation-delay:.2s;
}

@keyframes rowFade{
    to{
        opacity:1;
        transform:translateY(0);
    }
}
</style>

<div class="container-fluid">

<h3 class="page-title">🔔 Notifikasi Pengembalian Buku</h3>

<div class="card card-custom">
<div class="card-body">

<div class="table-responsive">
<table class="table table-bordered align-middle text-center">

<thead>
<tr>
    <th width="60">No</th>
    <th>Anggota</th>
    <th>Buku</th>
    <th width="150">Tanggal Kembali</th>
    <th width="130">Status</th>
    <th width="120">WhatsApp</th>
</tr>
</thead>

<tbody>

<?php if(!empty($notif)){ ?>
<?php $no=1; foreach($notif as $n){ 

    // Tentukan status & warna
    if($n->sisa_hari < 0){
        $row_class = 'status-terlambat';
        $badge = '<span class="badge bg-danger">Terlambat</span>';
    }elseif($n->sisa_hari == 0){
        $row_class = 'status-h1';
        $badge = '<span class="badge bg-danger">Hari Ini</span>';
    }elseif($n->sisa_hari == 1){
        $row_class = 'status-h1';
        $badge = '<span class="badge bg-danger">H-1</span>';
    }elseif($n->sisa_hari == 2){
        $row_class = 'status-h2';
        $badge = '<span class="badge bg-warning text-dark">H-2</span>';
    }else{
        $row_class = 'status-h3';
        $badge = '<span class="badge bg-primary">H-3</span>';
    }

    // Format WA
    $pesan = "Halo {$n->nama}, kami mengingatkan pengembalian buku {$n->judul}. Mohon dikembalikan sesuai jadwal. Terima kasih.";
?>

<tr class="<?= $row_class ?>">

<td><?= $no++ ?></td>
<td class="text-start"><?= $n->nama ?></td>
<td class="text-start"><?= $n->judul ?></td>
<td><?= date('d-m-Y', strtotime($n->tanggal_kembali)) ?></td>
<td><?= $badge ?></td>

<td>
<?php if(!empty($n->no_hp)){ ?>
<a target="_blank"
class="btn btn-success btn-sm"
href="https://wa.me/62<?= ltrim($n->no_hp,'0') ?>?text=<?= urlencode($pesan) ?>">
📲 WA
</a>
<?php }else{ ?>
<span class="text-muted">-</span>
<?php } ?>
</td>

</tr>

<?php } ?>
<?php }else{ ?>

<tr>
<td colspan="6" class="text-center text-muted py-4">
📭 Tidak ada notifikasi pengembalian
</td>
</tr>

<?php } ?>

</tbody>
</table>
</div>

</div>
</div>

</div>
</div>
<?php $this->load->view('template/footer'); ?>