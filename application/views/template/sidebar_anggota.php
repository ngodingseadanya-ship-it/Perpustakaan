<div class="sidebar" id="sidebar">

    <center style="padding-top:15px">
        <img src="<?= base_url('assets/img/logo-man.png') ?>" width="70">
    </center>

    <h3><?= $this->session->userdata('nama') ?></h3>
    <center>Anggota</center>

    <hr style="border-color:#444">

    <a href="<?= base_url('index.php/anggota_area')?>">📚 Buku</a>
    <a href="<?= base_url('index.php/anggota_area/favorit_list')?>">❤️ Favorit Buku</a>

    <a class="logout" href="<?= base_url('index.php/login/logout')?>">🚪 Logout</a>

</div>


<div class="content" id="content">

    <div class="topbar">
        <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
        <img src="<?= base_url('assets/img/logo-man.png') ?>" width="30" style="vertical-align:middle">
        &nbsp; Perpustakaan Digital MAN 2 Sleman
    </div>

<style>body {
    margin: 0;
    font-family: Arial, sans-serif;
}

/* Sidebar */
.sidebar {
    width: 240px;
    height: 100vh;
    background: #263238;
    color: #fff;
    position: fixed;
    left: 0;
    top: 0;
    transition: all 0.3s ease;
    overflow: hidden;
}

.sidebar h3 {
    text-align: center;
    margin: 10px 0;
}

.sidebar a {
    display: block;
    padding: 12px 20px;
    color: #fff;
    text-decoration: none;
}

.sidebar a:hover {
    background: #37474F;
}

.sidebar .logout {
    background: #c62828;
    margin: 20px;
    border-radius: 6px;
    text-align: center;
}

/* Sidebar hidden */
.sidebar.hide {
    left: -240px;
}

/* Content */
.content {
    margin-left: 240px;
    transition: all 0.3s ease;
}

/* Content full */
.content.full {
    margin-left: 0;
}

/* Topbar */
.topbar {
    background: #1976D2;
    color: #fff;
    padding: 12px;
    display: flex;
    align-items: center;
    gap: 10px;
}

/* Toggle button */
.toggle-btn {
    font-size: 20px;
    background: none;
    border: none;
    color: #fff;
    cursor: pointer;
}
</style>
<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('hide');
    document.getElementById('content').classList.toggle('full');
}
</script>
