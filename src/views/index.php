<?php
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}
$title = 'Ana Sayfa';
$isLoggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta charset="UTF-8">
    <title>Türkiye'yi Tanıyalım - Ana Sayfa</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        
        .navbar {
            background: rgba(255,255,255,0.95);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .logo a { font-size: 1.5rem; font-weight: bold; color: #333; text-decoration: none; }
        .logo span { color: #667eea; }
        
        .nav-links a {
            color: #333;
            text-decoration: none;
            margin-left: 1.5rem;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            transition: 0.3s;
        }
        .nav-links a:hover { background: #667eea; color: white; }
        
        .hero-section {
            background: linear-gradient(135deg, rgba(102,126,234,0.9), rgba(118,75,162,0.9)), url('https://images.pexels.com/photos/3586966/pexels-photo-3586966.jpeg');
            background-size: cover;
            background-position: center;
            min-height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            border-radius: 0 0 50px 50px;
            margin-bottom: 3rem;
        }
        
        .hero-title { font-size: 3.5rem; color: white; margin-bottom: 1rem; }
        .hero-subtitle { font-size: 1.2rem; color: rgba(255,255,255,0.9); margin-bottom: 2rem; }
        
        .btn {
            padding: 0.8rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
            display: inline-block;
            margin: 0 0.5rem;
        }
        .btn-primary { background: white; color: #667eea; }
        .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.2); }
        .btn-secondary { background: transparent; color: white; border: 2px solid white; }
        .btn-secondary:hover { background: white; color: #667eea; transform: translateY(-3px); }
        
        .features-section { padding: 3rem 2rem; max-width: 1200px; margin: 0 auto; }
        .section-title { text-align: center; margin-bottom: 3rem; }
        .section-title h2 { font-size: 2rem; color: white; margin-bottom: 0.5rem; }
        .section-title p { color: rgba(255,255,255,0.8); }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }
        
        .feature-card {
            background: rgba(255,255,255,0.95);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            transition: 0.3s;
        }
        .feature-card:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.2); }
        .feature-icon { font-size: 3rem; margin-bottom: 1rem; }
        .feature-card h3 { color: #333; margin-bottom: 0.5rem; }
        .feature-card p { color: #666; }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up { animation: fadeInUp 0.6s ease; }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo"><a href="index.php">🇹🇷 <span>Türkiye'yi</span> Tanıyalım</a></div>
        <div class="nav-links">
            <a href="index.php">Ana Sayfa</a>
            <?php if($isLoggedIn): ?>
                <a href="dashboard.php">Şehirler</a>
                <a href="profile.php">Profilim</a>
                <a href="../controllers/AuthController.php?action=logout">Çıkış Yap</a>
            <?php else: ?>
                <a href="login.php">Giriş Yap</a>
                <a href="register.php">Kayıt Ol</a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="hero-section">
    <div class="hero-content">
        <h1 class="hero-title animate-fade-in-up">✨ Güzel Türkiye'mizin ✨</h1>
        <h1 class="hero-title animate-fade-in-up" style="font-size: 4rem; background: linear-gradient(45deg, #ffd700, #ff8c00); -webkit-background-clip: text; background-clip: text; color: transparent;">Birbirinden Değerli Şehirleri</h1>
        <p class="hero-subtitle animate-fade-in-up">Türkiye'nin tüm güzelliklerini keşfedin, yorum yapın ve beğenin!</p>
        
        <?php if(!$isLoggedIn): ?>
            <div class="hero-buttons animate-fade-in-up">
                <a href="login.php" class="btn btn-primary">🔐 Giriş Yap</a>
                <a href="register.php" class="btn btn-secondary">📝 Kayıt Ol</a>
            </div>
        <?php else: ?>
            <div class="hero-buttons animate-fade-in-up">
                <a href="dashboard.php" class="btn btn-primary">🏙️ Şehirleri Keşfet</a>
            </div>
        <?php endif; ?>
    </div>
</div>

    <div class="features-section">
        <div class="section-title">
            <h2>🌟 Neler Yapabilirsiniz?</h2>
            <p>Türkiye'yi Tanıyalım platformunda sizi neler bekliyor?</p>
        </div>
        
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🏙️</div>
                <h3>81 Şehir</h3>
                <p>Türkiye'nin tüm illerini keşfedin, her şehrin detaylı bilgilerine ulaşın.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">⭐</div>
                <h3>Yorum & Puan</h3>
                <p>Gezdiğiniz şehirleri puanlayın, deneyimlerinizi paylaşın.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">❤️</div>
                <h3>Beğen</h3>
                <p>Sevdiğiniz şehirleri beğenin, favorilerinizi oluşturun.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">👤</div>
                <h3>Profilim</h3>
                <p>Profilinizi kişiselleştirin, beğenilerinizi ve yorumlarınızı görün.</p>
            </div>
        </div>
    </div>
    <?php require_once 'partials/footer.php'; ?>
</body>
</html>