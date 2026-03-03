<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/sidebar_anggota'); ?>

<style>
.fav-card {
    border-radius: 14px;
    box-shadow: 0 6px 20px rgba(0,0,0,.1);
}
.fav-title {
    font-weight: 600;
    font-size: 18px;
}
.total-badge {
    font-size: 14px;
}
.cover-img {
    width: 60px;
    height: 80px;
    object-fit: cover;
    border-radius: 6px;
    box-shadow: 0 2px 6px rgba(0,0,0,.15);
}
.table-fav th {
    background: #212529;
    color: #fff;
}
.table-fav tr:hover {
    background-color: #f8f9fa;
}
.search-input {
    max-width: 280px;
}
.empty-fav {
    padding: 40px;
    text-align: center;
    color: #6c757d;
}
.cover-wrap {
    width: 80px;
    height: 110px;
    padding: 6px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 6px 14px rgba(0,0,0,.18);
    display: flex;
    align-items: center;
    justify-content: center;
}

.cover-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 6px;
    transition: transform .3s ease;
}

.cover-wrap:hover .cover-img {
    transform: scale(1.08);
}

</style>

<div class="card fav-card">
<div class="card-body">

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div class="fav-title">
         Buku Favorit Saya
        <span class="badge bg-danger total-badge ms-2">
            Total: <?= count($buku) ?>
        </span>
    </div>

    <!-- SEARCH -->
    <input 
        type="text"
        id="searchFavorit"
        class="form-control form-control-sm search-input"
        placeholder="🔍 Cari judul buku..."
    >
</div>

<div class="table-responsive">
<table class="table table-hover table-bordered table-fav" id="tabelFavorit">

<thead>
<tr>
    <th width="60">No</th>
    <th width="120">Cover</th>
    <th>Judul Buku</th>
    <th width="120" class="text-center">Aksi</th>
</tr>
</thead>

<tbody>
<?php if(!empty($buku)){ ?>
<?php $no=1; foreach($buku as $b){ ?>

<tr>
    <td class="text-center"><?= $no++ ?></td>

    <td class="text-center">
        <div class="cover-wrap mx-auto">
    <img 
      src="<?= base_url('uploads/'.($b->gambar ? $b->gambar : 'default.png')) ?>"
      class="cover-img"
      alt="<?= $b->judul ?>"
    >
</div>

    </td>

    <td class="judul-buku"><?= $b->judul ?></td>

    <td class="text-center">
        <a 
          href="<?= base_url('index.php/anggota_area/hapus_favorit/'.$b->id_buku) ?>"
          class="btn btn-sm btn-outline-danger"
          onclick="return confirm('Hapus buku ini dari favorit?')"
        >
          ❌ Hapus
        </a>
    </td>
</tr>

<?php } ?>
<?php }else{ ?>

<tr>
<td colspan="4">
    <div class="empty-fav">
        💔 Belum ada buku favorit<br>
        <small>Tambahkan buku dari katalog</small>
    </div>
</td>
</tr>

<?php } ?>
</tbody>

</table>
</div>

</div>
</div>

<!-- SEARCH SCRIPT -->
<script>
document.getElementById("searchFavorit").addEventListener("keyup", function () {
    let keyword = this.value.toLowerCase();
    let rows = document.querySelectorAll("#tabelFavorit tbody tr");

    rows.forEach(function (row) {
        let judul = row.querySelector(".judul-buku");
        if (!judul) return;

        row.style.display = judul.textContent.toLowerCase().includes(keyword)
            ? ""
            : "none";
    });
});
</script>

<?php $this->load->view('template/footer'); ?>
