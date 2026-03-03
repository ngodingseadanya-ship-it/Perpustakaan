<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login | Sistem Perpustakaan</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins', sans-serif;
}

body{
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:url("<?= base_url('assets/img/bg.png') ?>") no-repeat center center;
    background-size:cover;
    position:relative;
}

/* Overlay Gelap Elegant */
body::before{
    content:"";
    position:absolute;
    width:100%;
    height:100%;
    background:linear-gradient(to right, rgba(0,0,0,.65), rgba(0,0,0,.4));
}

/* Login Card */
.login-container{
    position:relative;
    z-index:2;
    width:380px;
    background:rgba(255,255,255,0.97);
    backdrop-filter:blur(8px);
    border-radius:16px;
    padding:35px;
    box-shadow:0 20px 40px rgba(0,0,0,.3);
    animation:fadeIn .6s ease-in-out;
}

@keyframes fadeIn{
    from{opacity:0; transform:translateY(20px);}
    to{opacity:1; transform:translateY(0);}
}

.logo{
    text-align:center;
    margin-bottom:10px;
    font-size:40px;
}

h2{
    text-align:center;
    margin-bottom:5px;
    font-weight:600;
}

.subtitle{
    text-align:center;
    font-size:13px;
    color:#777;
    margin-bottom:25px;
}

.input-group{
    position:relative;
    margin-bottom:18px;
}

.input-group input{
    width:100%;
    padding:12px 40px 12px 14px;
    border-radius:8px;
    border:1px solid #ddd;
    font-size:14px;
    transition:.3s;
}

.input-group input:focus{
    border-color:#1976d2;
    outline:none;
    box-shadow:0 0 0 2px rgba(25,118,210,.2);
}

.toggle-password{
    position:absolute;
    right:12px;
    top:50%;
    transform:translateY(-50%);
    cursor:pointer;
    font-size:14px;
    color:#555;
}

button{
    width:100%;
    padding:12px;
    border:none;
    border-radius:8px;
    background:linear-gradient(135deg,#1976d2,#0d47a1);
    color:white;
    font-size:15px;
    font-weight:500;
    cursor:pointer;
    transition:.3s;
}

button:hover{
    transform:translateY(-2px);
    box-shadow:0 8px 20px rgba(0,0,0,.2);
}

.error{
    background:#ffebee;
    color:#c62828;
    padding:10px;
    border-radius:8px;
    margin-bottom:15px;
    font-size:13px;
    text-align:center;
}

.footer{
    text-align:center;
    margin-top:20px;
    font-size:12px;
    color:#999;
}

@media(max-width:480px){
    .login-container{
        width:90%;
        padding:25px;
    }
}
</style>
</head>
<body>

<div class="login-container">

<div class="logo">📚</div>
<h2>Sistem Perpustakaan</h2>
<div class="subtitle">Silakan login untuk melanjutkan</div>

<?php if($this->session->flashdata('error')): ?>
<div class="error">
<?= $this->session->flashdata('error') ?>
</div>
<?php endif ?>

<form method="post" action="<?= base_url('index.php/login/proses') ?>">

<!-- CSRF (jika aktif) -->
<input type="hidden" 
name="<?= $this->security->get_csrf_token_name(); ?>" 
value="<?= $this->security->get_csrf_hash(); ?>">

<div class="input-group">
<input type="text" name="username" placeholder="Username" required autofocus>
</div>

<div class="input-group">
<input type="password" name="password" id="password" placeholder="Password" required>
<span class="toggle-password" onclick="togglePassword()">👁</span>
</div>

<button type="submit">Masuk</button>

</form>

<div class="footer">
© <?= date('Y') ?> Sistem Perpustakaan
</div>

</div>

<script>
function togglePassword(){
    var x = document.getElementById("password");
    if(x.type === "password"){
        x.type = "text";
    } else {
        x.type = "password";
    }
}
</script>

</body>
</html>