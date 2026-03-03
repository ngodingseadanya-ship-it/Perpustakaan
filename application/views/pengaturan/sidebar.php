<?php $this->load->view('template/header'); ?>
<?php $this->load->view('template/sidebar'); ?>
<?php
$order = [
'menu_dashboard',
'menu_anggota',
'menu_kategori',
'menu_buku',
'menu_peminjaman',
'menu_notifikasi',
'menu_laporan',
'menu_denda',
'menu_pengunjung',
'menu_pengaturan'
];

usort($menu,function($a,$b) use ($order){
    return array_search($a->nama_pengaturan,$order)
         - array_search($b->nama_pengaturan,$order);
});
?>
<style>
.page-title{
    font-weight:700;
    font-size:22px;
}

.menu-card{
    background:#fff;
    border-radius:16px;
    padding:12px 20px;
    margin-bottom:14px;
    border:1px solid #eef2f7;
    transition:.25s;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.menu-card:hover{
    transform:translateY(-2px);
    box-shadow:0 8px 25px rgba(0,0,0,.05);
    border-color:#dbeafe;
}

.menu-name{
    font-weight:600;
    font-size:16px;
}

.status-badge{
    font-size:12px;
    padding:4px 10px;
    border-radius:999px;
    margin-left:10px;
}

.on{
    background:#dcfce7;
    color:#166534;
}

.off{
    background:#fee2e2;
    color:#991b1b;
}

.form-switch .form-check-input{
    width:52px;
    height:26px;
    cursor:pointer;
}

.form-switch .form-check-input:checked{
    background-color:#3b82f6;
    border-color:#3b82f6;
}

.toast-save{
    position:fixed;
    top:20px;
    right:20px;
    background:#111827;
    color:#fff;
    padding:14px 18px;
    border-radius:12px;
    font-size:14px;
    box-shadow:0 10px 30px rgba(0,0,0,.15);
    opacity:0;
    transform:translateY(-10px);
    transition:.3s;
    z-index:9999;
}

.toast-save.show{
    opacity:1;
    transform:translateY(0);
}
</style>

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="page-title">⚙️ Pengaturan Menu Sidebar</div>
    <small class="text-muted">Toggle untuk tampil / sembunyikan menu</small>
</div>

<div class="card border-0 shadow-sm rounded-4">
<div class="card-body">


<?php
$menu = $this->db
    ->like('nama_pengaturan','menu_')
    ->get('pengaturan')
    ->result();
?>
<?php foreach($menu as $m): 
$status = $m->nilai == 'on';
?>

<div class="menu-card">

    <div class="d-flex align-items-center">
        <div class="menu-name">
            <?= ucwords(str_replace('menu_','',$m->nama_pengaturan)) ?>
        </div>

        <span class="status-badge <?= $status?'on':'off' ?>" id="badge-<?= $m->nama_pengaturan ?>">
            <?= $status?'Aktif':'Nonaktif' ?>
        </span>
    </div>

    <div class="form-check form-switch m-0">
        <input class="form-check-input sidebar-toggle"
               type="checkbox"
               data-menu="<?= $m->nama_pengaturan ?>"
               <?= $status?'checked':'' ?>>
    </div>

</div>

<?php endforeach; ?>

</div>
</div>
</div>

<div class="toast-save" id="toast">
✔ Pengaturan tersimpan
</div>

<script>
document.querySelectorAll('.sidebar-toggle').forEach(toggle=>{

    toggle.addEventListener('change',function(){

        let menuName = this.dataset.menu;
        let status   = this.checked ? 'on' : 'off';

        fetch("<?= base_url('index.php/pengaturan/update_sidebar_ajax') ?>",{
            method:"POST",
            headers:{ "Content-Type":"application/x-www-form-urlencoded" },
            body:"menu="+menuName+"&status="+status
        })
        .then(res=>res.json())
        .then(data=>{

            if(data.success){

                // update badge text
                let badge = document.getElementById("badge-"+menuName);
                badge.textContent = status==='on'?'Aktif':'Nonaktif';
                badge.className = "status-badge " + (status==='on'?'on':'off');

                // show toast
                let toast=document.getElementById("toast");
                toast.classList.add("show");
                setTimeout(()=>toast.classList.remove("show"),2000);

                // realtime sidebar hide/show
                let target=document.querySelector('[data-sidebar="'+menuName+'"]');
                if(target){
                    target.style.display = status==='on' ? "flex" : "none";
                }

            }

        });

    });

});
</script>

<?php $this->load->view('template/footer'); ?>