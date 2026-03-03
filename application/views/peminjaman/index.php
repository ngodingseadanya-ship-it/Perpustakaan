<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/sidebar'); ?>

<style>
body{background:#f4f6f9;}
.custom-card{
background:#fff;border-radius:15px;
box-shadow:0 8px 25px rgba(0,0,0,0.06);
padding:25px;margin-bottom:25px;
animation:fadeIn .4s ease-in-out;
}
@keyframes fadeIn{
from{opacity:0; transform:translateY(10px);}
to{opacity:1; transform:translateY(0);}
}
.section-title{
font-weight:600;margin-bottom:20px;
border-left:5px solid #0d6efd;padding-left:10px;
}
.form-control,.form-select{border-radius:10px;}
.table thead{
background:linear-gradient(90deg,#0d6efd,#4e73df);
color:white;
}
.badge{padding:6px 10px;border-radius:8px;}
.btn{border-radius:10px;}
</style>

<h3 class="mb-4 fw-bold">📚 Transaksi Peminjaman Buku</h3>

<!-- ================= FORM ================= -->
<div class="custom-card">

<?php if($this->session->flashdata('error')){ ?>
<div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
<?php } ?>

<?php if($this->session->flashdata('success')){ ?>
<div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
<?php } ?>

<h5 class="section-title">Form Peminjaman</h5>

<form method="post" action="<?= base_url('index.php/peminjaman/tambah') ?>" class="row g-3">

<div class="col-md-3">
<label>NIS</label>
<select id="nis" class="form-control" required>
<option value="">-- Pilih NIS --</option>
<?php foreach($anggota as $a){
$isAlumni = strtolower(trim($a->kelas))=='alumni'; ?>
<option value="<?= $a->id_anggota ?>"
data-nama="<?= $a->nama ?>"
data-kelas="<?= $a->kelas ?>"
<?= $isAlumni?'disabled':'' ?>>
<?= $a->nis ?> <?= $isAlumni?'(Alumni)':'' ?>
</option>
<?php } ?>
</select>
</div>

<div class="col-md-4">
<label>Nama Anggota</label>
<input type="text" id="nama_anggota" class="form-control" readonly>
<input type="hidden" name="anggota" id="id_anggota">
</div>

<div class="col-md-3">
<label>Kelas</label>
<input type="text" id="kelas" class="form-control" readonly>
</div>

<div class="col-md-2">
<label>Pinjaman Aktif</label>
<input id="aktif" class="form-control" readonly>
</div>

<div class="col-md-4">
<label>Buku</label>
<select id="buku" class="form-control">
<option value="">-- Pilih Buku --</option>
<?php foreach($buku as $b){ ?>
<option value="<?= $b->id_buku ?>" data-judul="<?= $b->judul ?>" data-stok="<?= $b->stok ?>">
<?= $b->judul ?> (stok <?= $b->stok ?>)
</option>
<?php } ?>
</select>
</div>

<div class="col-md-2">
<label>Jumlah</label>
<input type="number" id="qty" class="form-control" value="1" min="1">
</div>

<div class="col-md-2 d-flex align-items-end">
<button type="button" class="btn btn-primary w-100" onclick="tambahBuku()">➕ Tambah</button>
</div>

<div class="col-12">
<table class="table table-hover">
<thead>
<tr>
<th>Judul Buku</th>
<th>Qty</th>
<th width="120">Aksi</th>
</tr>
</thead>
<tbody id="listBuku"></tbody>
</table>
</div>

<input type="hidden" name="buku_data" id="buku_data">

<div class="col-12">
<button class="btn btn-success">💾 Simpan Peminjaman</button>
</div>

</form>
</div>

<!-- ================= FILTER ================= -->
<div class="custom-card">
<h5 class="section-title">Filter Data</h5>

<?php
$q=$this->input->get('q');
$status=$this->input->get('status');
$ganti=$this->input->get('ganti');
$filter=$this->input->get('filter');
$tanggal=$this->input->get('tanggal');
?>

<form method="get" id="formFilter" class="row g-3">

<div class="col-md-3">
<input type="text" name="q" class="form-control auto-filter"
placeholder="Cari anggota / buku"
value="<?= htmlspecialchars($q) ?>">
</div>

<div class="col-md-2">
<select name="status" class="form-control auto-filter">
<option value="">Semua Status</option>
<option value="dipinjam" <?= $status=='dipinjam'?'selected':'' ?>>Dipinjam</option>
<option value="dikembalikan" <?= $status=='dikembalikan'?'selected':'' ?>>Dikembalikan</option>
<option value="rusak" <?= $status=='rusak'?'selected':'' ?>>Rusak</option>
<option value="hilang" <?= $status=='hilang'?'selected':'' ?>>Hilang</option>
</select>
</div>

<div class="col-md-2">
<select name="ganti" class="form-control auto-filter">
<option value="">Penggantian</option>
<option value="belum" <?= $ganti=='belum'?'selected':'' ?>>Belum</option>
<option value="sudah" <?= $ganti=='sudah'?'selected':'' ?>>Sudah</option>
<option value="tidak_perlu" <?= $ganti=='tidak_perlu'?'selected':'' ?>>Tidak Perlu</option>
</select>
</div>

<div class="col-md-2">
<select name="filter" class="form-control auto-filter">
<option value="">Waktu</option>
<option value="harian" <?= $filter=='harian'?'selected':'' ?>>Harian</option>
<option value="mingguan" <?= $filter=='mingguan'?'selected':'' ?>>Mingguan</option>
<option value="bulanan" <?= $filter=='bulanan'?'selected':'' ?>>Bulanan</option>
<option value="tahunan" <?= $filter=='tahunan'?'selected':'' ?>>Tahunan</option>
</select>
</div>

<div class="col-md-3">
<input type="date" name="tanggal" class="form-control auto-filter"
value="<?= htmlspecialchars($tanggal) ?>">
</div>

</form>
</div>

<!-- ================= DATA ================= -->
<div class="custom-card">
<h5 class="section-title">Data Peminjaman</h5>

<table class="table table-hover">
<thead>
<tr>
<th>No</th>
<th>NIS</th>
<th>Nama</th>
<th>Buku</th>
<th>Jumlah</th>
<th>Tgl Pinjam</th>
<th>Jatuh Tempo</th>
<th>Dikembalikan</th>
<th>Status</th>
<?php if($denda_status=='on'){ ?>
<th>Denda</th>
<th>Bayar</th>
<?php } ?>
<th>Ganti</th>
<th>Aksi</th>
</tr>
</thead>
<tbody>

<?php if(!empty($data)): ?>
<?php $no=1; foreach($data as $d): ?>

<?php
$statusLabel=$d->status??'dipinjam';
$denda=$d->denda??0;
$bayar=$d->status_bayar??'belum';

$warna=[
'dipinjam'=>'warning',
'dikembalikan'=>'success',
'rusak'=>'danger',
'hilang'=>'dark'
];
?>

<tr class="<?= $denda>0?'table-danger':'' ?>">
<td><?= $no++ ?></td>
<td><?= $d->nis ?></td>
<td><?= $d->nama ?></td>
<td><?= $d->judul ?></td>
<td><?= $d->jumlah ?></td>
<td><?= $d->tanggal_pinjam ?></td>
<td><?= $d->tanggal_kembali ?></td>
<td><?= $d->tanggal_dikembalikan?:'-' ?></td>

<td><span class="badge bg-<?= $warna[$statusLabel] ?>"><?= ucfirst($statusLabel) ?></span></td>

<?php if($denda_status=='on'): ?>
<td><?= $denda>0?'<span class="badge bg-danger">Rp '.number_format($denda).'</span>':'-' ?></td>
<td><?= $denda>0?($bayar=='lunas'?'<span class="badge bg-success">Lunas</span>':'<span class="badge bg-danger">Belum</span>'):'-' ?></td>
<?php endif; ?>

<td>
<?php if(in_array($statusLabel,['rusak','hilang'])): ?>
<?= ($d->status_ganti??'belum')=='sudah'
?'<span class="badge bg-success">Sudah</span>'
:'<span class="badge bg-danger">Belum</span>'; ?>
<?php else: ?>
<span class="badge bg-secondary">Tidak</span>
<?php endif; ?>
</td>

<td>

<form method="post" action="<?= base_url('index.php/peminjaman/update_status') ?>">
<input type="hidden" name="id_detail" value="<?= $d->id_detail ?>">
<select name="status" class="form-select form-select-sm mb-1"
onchange="if(confirm('Ubah status buku?')) this.form.submit();">
<option value="dipinjam" <?= $statusLabel=='dipinjam'?'selected':'' ?>>Dipinjam</option>
<option value="dikembalikan" <?= $statusLabel=='dikembalikan'?'selected':'' ?>>Dikembalikan</option>
<option value="rusak" <?= $statusLabel=='rusak'?'selected':'' ?>>Rusak</option>
<option value="hilang" <?= $statusLabel=='hilang'?'selected':'' ?>>Hilang</option>
</select>
</form>

<?php if($denda_status=='on' && $denda>0 && $bayar!='lunas'): ?>
<a href="<?= base_url('index.php/peminjaman/bayar_denda/'.$d->id_detail) ?>"
class="btn btn-success btn-sm w-100 mt-1"
onclick="return confirm('Konfirmasi pembayaran denda?')">
Bayar Denda
</a>
<?php endif; ?>

<?php if(in_array($statusLabel,['rusak','hilang']) && ($d->status_ganti??'belum')!='sudah'): ?>
<a href="<?= base_url('index.php/peminjaman/form_ganti/'.$d->id_detail) ?>"
class="btn btn-danger btn-sm w-100 mt-1">
Konfirmasi Ganti
</a>
<?php endif; ?>

</td>

</tr>

<?php endforeach; ?>

<?php else: ?>

<tr>
<td colspan="13" class="text-center">Belum ada data</td>
</tr>

<?php endif; ?>

</tbody>
</table>

</div>

<!-- ================= SCRIPT ================= -->
<script>

document.getElementById("nis").addEventListener("change",function(){
let opt=this.options[this.selectedIndex];
document.getElementById("nama_anggota").value=opt.dataset.nama||"";
document.getElementById("kelas").value=opt.dataset.kelas||"";
document.getElementById("id_anggota").value=this.value||"";

if(this.value){
fetch("<?= base_url('index.php/peminjaman/cek_pinjam') ?>",{
method:"POST",
headers:{"Content-Type":"application/x-www-form-urlencoded"},
body:"id="+this.value
})
.then(r=>r.json())
.then(d=>document.getElementById("aktif").value=d.jumlah);
}
});

let daftarBuku=[];

function tambahBuku(){
let s=document.getElementById("buku");
let id=s.value;
if(!id)return alert("Pilih buku");

let judul=s.options[s.selectedIndex].dataset.judul;
let stok=parseInt(s.options[s.selectedIndex].dataset.stok);
let qty=parseInt(document.getElementById("qty").value);

if(qty>stok)return alert("Stok tidak cukup");

let ex=daftarBuku.find(b=>b.id==id);
if(ex)ex.qty+=qty;
else daftarBuku.push({id,judul,qty});

render();
}

function render(){
let tb=document.getElementById("listBuku");
tb.innerHTML="";
daftarBuku.forEach((b,i)=>{
tb.innerHTML+=`<tr>
<td>${b.judul}</td>
<td>${b.qty}</td>
<td><button type="button" class="btn btn-danger btn-sm" onclick="hapus(${i})">Hapus</button></td>
</tr>`;
});
document.getElementById("buku_data").value=JSON.stringify(daftarBuku);
}

function hapus(i){daftarBuku.splice(i,1);render();}

document.querySelectorAll(".auto-filter").forEach(el=>{
el.addEventListener("change",()=>document.getElementById("formFilter").submit());
});
</script>