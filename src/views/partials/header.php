<?php
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Türkiye\'yi Tanıyalım' ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
        <div class="logo"><a href="index.php">🇹🇷 <span>Türkiye'yi</span> Tanıyalım</a></div>
        <div class="nav-links">
            <a href="index.php">Ana Sayfa</a>
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="dashboard.php">Şehirler</a>
                <a href="profile.php">Profilim</a>
                <a href="../controllers/AuthController.php?action=logout">Çıkış Yap</a>
            <?php else: ?>
                <a href="login.php">Giriş Yap</a>
                <a href="register.php">Kayıt Ol</a>
            <?php endif; ?>
        </div>
    </nav>
    <main class="main-content">