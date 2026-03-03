<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<title>Sistem Informasi Perpustakaan</title>

<style>
:root{
    --primary:#0d6efd;
    --dark:#1e293b;
    --dark2:#0f172a;
    --light-bg:#f4f6f9;
}

body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:var(--light-bg);
}

/* ================= SIDEBAR ================= */
.sidebar{
    position:fixed;
    left:0;
    top:0;
    width:250px;
    height:100vh;
    background:linear-gradient(180deg,var(--dark),var(--dark2));
    color:#fff;
    overflow-y:auto;
    box-shadow:4px 0 20px rgba(0,0,0,.05);
    transition:.3s;
}

.sidebar-header{
    text-align:center;
    padding:25px 15px 15px;
}

.sidebar-header img{
    width:65px;
    margin-bottom:10px;
}

.sidebar-header h6{
    margin:0;
    font-weight:600;
}

.sidebar-header small{
    opacity:.6;
}

/* MENU */
.sidebar a{
    display:flex;
    align-items:center;
    gap:10px;
    padding:12px 20px;
    color:#cbd5e1;
    text-decoration:none;
    font-size:14px;
    transition:.2s;
}

.sidebar a:hover{
    background:rgba(255,255,255,.08);
    padding-left:25px;
    color:#fff;
}

.sidebar a.active{
    background:linear-gradient(90deg,var(--primary),#4e73df);
    color:#fff;
}

.sidebar hr{
    border-color:rgba(255,255,255,.1);
    margin:15px 0;
}

.sidebar .logout{
    color:#ff6b6b;
}

/* ================= CONTENT ================= */
.content{
    margin-left:250px;
    padding:25px;
    transition:.3s;
}

/* ================= TOPBAR ================= */
.topbar{
    background:#fff;
    padding:15px 25px;
    margin:-25px -25px 25px -25px;
    box-shadow:0 4px 12px rgba(0,0,0,.05);
    font-weight:600;
    display:flex;
    align-items:center;
    justify-content:space-between;
}

.toggle-btn{
    cursor:pointer;
    font-size:20px;
}

/* COLLAPSE */
.sidebar.collapsed{
    width:0;
    overflow:hidden;
}

.content.collapsed{
    margin-left:0;
}
</style>

<script>
document.addEventListener("DOMContentLoaded",function(){

    const sidebar=document.querySelector('.sidebar');
    const content=document.querySelector('.content');
    const toggle=document.getElementById('toggleSidebar');

    if(localStorage.getItem('sidebar')==='hide'){
        sidebar.classList.add('collapsed');
        content.classList.add('collapsed');
    }

    toggle.addEventListener('click',function(){
        sidebar.classList.toggle('collapsed');
        content.classList.toggle('collapsed');

        if(sidebar.classList.contains('collapsed')){
            localStorage.setItem('sidebar','hide');
        }else{
            localStorage.setItem('sidebar','show');
        }
    });

});
</script>

</head>
<body>