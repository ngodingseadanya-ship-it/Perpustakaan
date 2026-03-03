<?php
$notif_count = isset($notif_count) ? $notif_count : 0;
$logo = isset($logo) ? $logo : 'default.png';
$menu_dashboard   = $this->Pengaturan_model->get('menu_dashboard')   ?? 'on';
$menu_anggota     = $this->Pengaturan_model->get('menu_anggota')     ?? 'on';
$menu_kategori    = $this->Pengaturan_model->get('menu_kategori')    ?? 'on';
$menu_buku        = $this->Pengaturan_model->get('menu_buku')        ?? 'on';
$menu_peminjaman  = $this->Pengaturan_model->get('menu_peminjaman')  ?? 'on';
$menu_notifikasi  = $this->Pengaturan_model->get('menu_notifikasi')  ?? 'on';
$menu_laporan     = $this->Pengaturan_model->get('menu_laporan')     ?? 'on';
$menu_denda       = $this->Pengaturan_model->get('menu_denda')       ?? 'on';
$menu_pengunjung  = $this->Pengaturan_model->get('menu_pengunjung')  ?? 'on';
$menu_pengaturan  = $this->Pengaturan_model->get('menu_pengaturan')  ?? 'on';
?>

<style>
/* ===== SIDEBAR BASE ===== */
.sidebar{
    width:260px;
    min-height:100vh;
    background: linear-gradient(180deg,#0f1c2e,#16263f);
    color:#fff;
    position:fixed;
    left:0;
    top:0;
    padding:20px 15px;
    transition: transform .35s ease, width .35s ease;
    box-shadow: 4px 0 25px rgba(0,0,0,0.3);
}
.sidebar.collapsed{
    transform: translateX(-100%);
    width:260px; /* tetap sama */
}

/* ===== HEADER PROFILE ===== */
.sidebar-header{
    text-align:center;
    margin-bottom:25px;
}
.content{
    margin-left:260px;
    transition:.35s ease;
}
.content.collapsed{
    margin-left:0;
}
.sidebar-header img{
    width:80px;
    height:80px;
    border-radius:50%;
    object-fit:cover;
    box-shadow: 0 0 25px rgba(0,140,255,0.6);
    margin-bottom:10px;
}

.sidebar-header h6{
    margin:0;
    font-weight:600;
    font-size:16px;
    color:#fff;
}

.sidebar-header small{
    color:#9caecf;
}

/* ===== MENU LINKS ===== */
.sidebar a{
    display:flex;
    align-items:center;
    gap:10px;
    padding:12px 15px;
    margin:6px 0;
    border-radius:12px;
    color:#d5e3ff;
    text-decoration:none;
    transition: all 0.25s ease;
    font-size:14px;
}

/* Hover effect */
.sidebar a:hover{
    background:rgba(255,255,255,0.05);
    transform:translateX(5px);
    color:#fff;
}

/* Active state */
.sidebar a.active{
    background: linear-gradient(90deg,#1e5eff,#3f8cff);
    color:#fff;
    box-shadow: 0 0 15px rgba(30,94,255,0.6);
}

/* ===== DROPDOWN CARET ===== */
.menu-toggle{
    justify-content:space-between;
}

.menu-toggle .caret{
    transition:0.3s ease;
}

.menu-toggle.active .caret{
    transform:rotate(90deg);
}

/* ===== SUBMENU ===== */
.submenu{
    display:none;
    flex-direction:column;
    margin-left:15px;
}

.submenu a{
    font-size:13px;
    padding:8px 10px;
    opacity:0.8;
}

.submenu a:hover{
    opacity:1;
}

.submenu.show{
    display:flex;
}

/* ===== NOTIFICATION BADGE ===== */
.badge{
    margin-left:auto;
    background:#ff3b3b;
    font-size:11px;
    padding:4px 7px;
    border-radius:20px;
}

/* ===== LOGOUT BUTTON ===== */
.logout{
    margin-top:20px;
    background:rgba(255,0,0,0.1);
    border-radius:14px;
    color:#ff6b6b !important;
    justify-content:center;
    font-weight:500;
}

.logout:hover{
    background:rgba(255,0,0,0.2);
    transform:none;
}
</style>


<div class="sidebar">

<div class="sidebar-header">
<img src="<?= base_url('assets/logo/'.$logo) ?>" width="70">
<h6><?= $this->session->userdata('nama') ?></h6>
<small>Petugas</small>
</div>

<hr>

<?php if($menu_dashboard=='on'){ ?>
<a data-sidebar="menu_dashboard"
   href="<?= base_url('index.php/dashboard')?>"
   class="<?= uri_string()=='dashboard'?'active':'' ?>">
🏠 Dashboard
</a>
<?php } ?>

<?php if($menu_anggota=='on'){ ?>
<a data-sidebar="menu_anggota"
   href="<?= base_url('index.php/anggota')?>"
   class="<?= uri_string()=='anggota'?'active':'' ?>">
👨‍🎓 Anggota
</a>
<?php } ?>

<?php if($menu_kategori=='on'){ ?>
<a data-sidebar="menu_kategori"
   href="<?= base_url('index.php/kategori')?>"
   class="<?= uri_string()=='kategori'?'active':'' ?>">
🗂 Kategori
</a>
<?php } ?>

<?php if($menu_buku=='on'){ ?>
<div class="menu-item" data-sidebar="menu_buku">

<a href="javascript:void(0)" 
   onclick="toggleDropdown('bukuMenu', this)" 
   class="menu-toggle <?= (uri_string()=='buku' || uri_string()=='buku/katalog')?'active':'' ?>">
📚 Buku
<span class="caret">▶</span>
</a>

<div id="bukuMenu" 
     class="submenu <?= (uri_string()=='buku' || uri_string()=='buku/katalog')?'show':'' ?>">
    
    <a href="<?= base_url('index.php/buku/katalog')?>">📖 Katalog</a>
    <a href="<?= base_url('index.php/buku')?>">📋 Tabel Buku</a>

</div>
</div>
<?php } ?>

<hr>

<?php if($menu_peminjaman=='on'){ ?>
<a data-sidebar="menu_peminjaman"
   href="<?= base_url('index.php/peminjaman')?>"
   class="<?= uri_string()=='peminjaman'?'active':'' ?>">
🔄 Transaksi Peminjaman
</a>
<?php } ?>

<?php if($menu_notifikasi=='on'){ ?>
<a data-sidebar="menu_notifikasi"
   href="<?= base_url('index.php/notifikasi')?>"
   class="<?= uri_string()=='notifikasi'?'active':'' ?>">
🔔 Notifikasi
<?php if($notif_count > 0){ ?>
<span class="badge"><?= $notif_count ?></span>
<?php } ?>
</a>
<?php } ?>

<?php if($menu_laporan=='on'){ ?>
<a data-sidebar="menu_laporan"
   href="<?= base_url('index.php/laporan/peminjaman')?>"
   class="<?= uri_string()=='laporan/peminjaman'?'active':'' ?>">
   📄 Laporan Peminjaman
</a>
   
<?php } ?>

<?php if($menu_denda=='on'){ ?>
<a data-sidebar="menu_denda"
   href="<?= base_url('index.php/peminjaman/laporan_denda') ?>"
   class="<?= uri_string()=='peminjaman/laporan_denda' ? 'active' : '' ?>">
   💰 Laporan Denda
</a>
<?php } ?>

<?php if($menu_pengunjung=='on'){ ?>
<a data-sidebar="menu_pengunjung"
   href="<?= base_url('index.php/pengunjung')?>"
   class="<?= strpos(uri_string(),'pengunjung') === 0 ? 'active' : '' ?>">
   👥 Laporan Pengunjung
</a>
<?php } ?>

<hr>

<?php if($menu_pengaturan=='on'){ ?>
<a data-sidebar="menu_pengaturan"
   href="<?= base_url('index.php/pengaturan')?>"
   class="<?= strpos(uri_string(),'pengaturan') === 0 ? 'active' : '' ?>">
   ⚙ Pengaturan Sistem
</a>
<?php } ?>

<a class="logout" href="<?= base_url('index.php/login/logout')?>">🚪 Logout</a>

</div>

<div class="content">
<div class="topbar">
<div>
<span id="toggleSidebar" class="toggle-btn">☰</span>
Sistem Informasi Perpustakaan
</div>
<div><?= date('d M Y') ?></div>
</div>

<script>
function toggleDropdown(id, element){
    var submenu = document.getElementById(id);
    submenu.classList.toggle("show");
    element.classList.toggle("active");
}
document.addEventListener("DOMContentLoaded", function(){

    // Dengarkan perubahan toggle di halaman pengaturan
    document.querySelectorAll('.sidebar-toggle').forEach(toggle => {

        toggle.addEventListener('change', function(){

            let menuName = this.dataset.menu;
            let status   = this.checked ? 'on' : 'off';

            // Update database via AJAX
            fetch("<?= base_url('index.php/pengaturan/update_sidebar_ajax') ?>",{
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: "menu="+menuName+"&status="+status
            });

            // Hide / Show menu realtime
            let target = document.querySelector('[data-sidebar="'+menuName+'"]');

            if(target){
                if(status === 'off'){
                    target.style.display = "none";
                } else {
                    target.style.display = "";
                }
            }

        });

    });

});
</script>