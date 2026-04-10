<?php
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

$title = 'Giriş Yap';
$error = $_SESSION['error'] ?? null;
$success = $_SESSION['success'] ?? null;
unset($_SESSION['error'], $_SESSION['success']);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta charset="UTF-8">
    <title>Giriş Yap - Türkiye'yi Tanıyalım</title>
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
        }
        .logo a { font-size: 1.5rem; font-weight: bold; color: #333; text-decoration: none; }
        .logo span { color: #667eea; }
        .nav-links a { color: #333; text-decoration: none; margin-left: 1.5rem; padding: 0.5rem 1rem; border-radius: 25px; transition: 0.3s; }
        .nav-links a:hover { background: #667eea; color: white; }
        
        .form-container { display: flex; justify-content: center; align-items: center; min-height: 80vh; padding: 2rem; }
        .form-card {
            background: white;
            border-radius: 30px;
            padding: 2.5rem;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 25px 45px rgba(0,0,0,0.2);
            animation: fadeInUp 0.6s ease;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .form-card h2 { text-align: center; margin-bottom: 1.5rem; color: #333; font-size: 2rem; }
        .form-group { margin-bottom: 1.2rem; }
        .form-group input {
            width: 100%;
            padding: 1rem;
            border: 2px solid #eee;
            border-radius: 15px;
            font-size: 1rem;
            transition: 0.3s;
        }
        .form-group input:focus { outline: none; border-color: #667eea; }
        button {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 15px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover { transform: translateY(-2px); }
        .alert { padding: 1rem; border-radius: 15px; margin-bottom: 1.5rem; text-align: center; }
        .alert.error { background: #fee2e2; color: #dc2626; }
        .alert.success { background: #dcfce7; color: #16a34a; }
        .form-link { text-align: center; margin-top: 1.5rem; color: #666; }
        .form-link a { color: #667eea; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo"><a href="index.php">🇹🇷 <span>Türkiye'yi</span> Tanıyalım</a></div>
        <div class="nav-links">
            <a href="index.php">Ana Sayfa</a>
            <a href="login.php">Giriş Yap</a>
            <a href="register.php">Kayıt Ol</a>
        </div>
    </nav>

    <div class="form-container">
        <div class="form-card">
            <h2>🔐 Giriş Yap</h2>
            <?php if($error): ?>
                <div class="alert error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php if($success): ?>
                <div class="alert success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>
            
            <form action="../controllers/AuthController.php?action=login" method="POST">
                <div class="form-group">
                    <input type="text" name="username" placeholder="Kullanıcı Adı" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Şifre" required>
                </div>
                <button type="submit">Giriş Yap</button>
            </form>
            <p class="form-link">Hesabınız yok mu? <a href="register.php">Kayıt Olun</a></p>
        </div>
    </div>
    <?php require_once 'partials/footer.php'; ?>
</body>
</html>