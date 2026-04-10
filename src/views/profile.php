<?php
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../config/database.php';

if(!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_bio'])) {
    $bio = $_POST['bio'];
    $updateStmt = $pdo->prepare("UPDATE users SET bio = ? WHERE id = ?");
    $updateStmt->execute([htmlspecialchars($bio), $_SESSION['user_id']]);
    $_SESSION['success'] = "Biyografi güncellendi!";
    header('Location: profile.php');
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_image'])) {
    $file = $_FILES['profile_image'];
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    if(in_array($ext, $allowed)) {
        $filename = time() . '_' . uniqid() . '.' . $ext;
        $uploadPath = '../assets/images/uploads/' . $filename;
        
        if(move_uploaded_file($file['tmp_name'], $uploadPath)) {
            $updateStmt = $pdo->prepare("UPDATE users SET profile_image = ? WHERE id = ?");
            $updateStmt->execute([$filename, $_SESSION['user_id']]);
            $_SESSION['success'] = "Profil fotoğrafı güncellendi!";
            header('Location: profile.php');
            exit();
        }
    } else {
        $_SESSION['error'] = "Geçersiz dosya formatı!";
    }
}

$likedStmt = $pdo->prepare("
    SELECT c.* FROM cities c 
    JOIN likes l ON c.id = l.city_id 
    WHERE l.user_id = ? 
    ORDER BY l.created_at DESC
");
$likedStmt->execute([$_SESSION['user_id']]);
$likedCities = $likedStmt->fetchAll();

$commentStmt = $pdo->prepare("
    SELECT c.*, ct.name as city_name, ct.id as city_id 
    FROM comments c 
    JOIN cities ct ON c.city_id = ct.id 
    WHERE c.user_id = ? 
    ORDER BY c.created_at DESC
");
$commentStmt->execute([$_SESSION['user_id']]);
$userComments = $commentStmt->fetchAll();

$success = $_SESSION['success'] ?? null;
$error = $_SESSION['error'] ?? null;
unset($_SESSION['success'], $_SESSION['error']);

$title = 'Profilim';
?>
<?php

require_once '../config/database.php';

if(!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Kullanıcı bilgilerini çek
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

// Profil güncelleme
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_bio'])) {
    $bio = $_POST['bio'];
    $updateStmt = $pdo->prepare("UPDATE users SET bio = ? WHERE id = ?");
    $updateStmt->execute([htmlspecialchars($bio), $_SESSION['user_id']]);
    $_SESSION['success'] = "Biyografi güncellendi!";
    header('Location: profile.php');
    exit();
}

// Fotoğraf yükleme
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_image'])) {
    $file = $_FILES['profile_image'];
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    if(in_array($ext, $allowed)) {
        $filename = time() . '_' . uniqid() . '.' . $ext;
        $uploadPath = '../assets/images/uploads/' . $filename;
        
        if(move_uploaded_file($file['tmp_name'], $uploadPath)) {
            $updateStmt = $pdo->prepare("UPDATE users SET profile_image = ? WHERE id = ?");
            $updateStmt->execute([$filename, $_SESSION['user_id']]);
            $_SESSION['success'] = "Profil fotoğrafı güncellendi!";
            header('Location: profile.php');
            exit();
        }
    } else {
        $_SESSION['error'] = "Geçersiz dosya formatı!";
    }
}

// Beğenilen şehirler
$likedStmt = $pdo->prepare("
    SELECT c.* FROM cities c 
    JOIN likes l ON c.id = l.city_id 
    WHERE l.user_id = ? 
    ORDER BY l.created_at DESC
");
$likedStmt->execute([$_SESSION['user_id']]);
$likedCities = $likedStmt->fetchAll();

// Kullanıcının yorumları
$commentStmt = $pdo->prepare("
    SELECT c.*, ct.name as city_name, ct.id as city_id 
    FROM comments c 
    JOIN cities ct ON c.city_id = ct.id 
    WHERE c.user_id = ? 
    ORDER BY c.created_at DESC
");
$commentStmt->execute([$_SESSION['user_id']]);
$userComments = $commentStmt->fetchAll();

$success = $_SESSION['success'] ?? null;
$error = $_SESSION['error'] ?? null;
unset($_SESSION['success'], $_SESSION['error']);

$title = 'Profilim';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta charset="UTF-8">
    <title>Profilim - Türkiye'yi Tanıyalım</title>
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
        .nav-links a {
            color: #333;
            text-decoration: none;
            margin-left: 1.5rem;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            transition: 0.3s;
        }
        .nav-links a:hover { background: #667eea; color: white; }
        
        .profile-container { max-width: 1000px; margin: 0 auto; padding: 2rem; }
        .profile-card {
            background: white;
            border-radius: 30px;
            padding: 2rem;
            text-align: center;
            margin-bottom: 2rem;
        }
        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #667eea;
            margin-bottom: 1rem;
        }
        .profile-stats { display: flex; justify-content: center; gap: 2rem; margin: 2rem 0; }
        .stat-box { background: #f8f9fa; padding: 1rem 2rem; border-radius: 20px; text-align: center; }
        .stat-number { font-size: 2rem; font-weight: bold; color: #667eea; }
        
        .section { background: white; border-radius: 30px; padding: 1.5rem; margin-bottom: 2rem; }
        .section h3 { margin-bottom: 1rem; }
        .city-tag {
            display: inline-block;
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            text-decoration: none;
            margin: 0.3rem;
        }
        .comment-mini { border-bottom: 1px solid #eee; padding: 1rem; }
        .bio-form textarea, .file-input input { width: 100%; padding: 1rem; border: 2px solid #eee; border-radius: 15px; margin: 1rem 0; font-family: inherit; }
        .btn-save {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 25px;
            cursor: pointer;
        }
        .alert { padding: 1rem; border-radius: 15px; margin-bottom: 1rem; text-align: center; }
        .alert.success { background: #dcfce7; color: #16a34a; }
        .alert.error { background: #fee2e2; color: #dc2626; }
        .file-label {
            background: #f8f9fa;
            padding: 0.8rem 1.5rem;
            border-radius: 25px;
            cursor: pointer;
            display: inline-block;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo"><a href="dashboard.php">🇹🇷 <span>Türkiye'yi</span> Tanıyalım</a></div>
        <div class="nav-links">
            <a href="dashboard.php">Ana Sayfa</a>
            <a href="profile.php">Profilim</a>
            <a href="../controllers/AuthController.php?action=logout">Çıkış Yap</a>
        </div>
    </nav>

    <div class="profile-container">
        <?php if($success): ?>
            <div class="alert success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <?php if($error): ?>
            <div class="alert error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <div class="profile-card">
            <img src="../assets/images/uploads/<?= $user['profile_image'] ?: 'default.jpg' ?>" class="profile-image">
            <h2><?= htmlspecialchars($user['username']) ?></h2>
            <p><?= htmlspecialchars($user['email']) ?></p>
            <p><small>Üyelik: <?= date('d.m.Y', strtotime($user['created_at'])) ?></small></p>
            
            <div class="profile-stats">
                <div class="stat-box">
                    <div class="stat-number"><?= count($likedCities) ?></div>
                    <div>Beğenilen Şehir</div>
                </div>
                <div class="stat-box">
                    <div class="stat-number"><?= count($userComments) ?></div>
                    <div>Yapılan Yorum</div>
                </div>
            </div>
            
            <div class="bio-form">
                <h3>Biyografi</h3>
                <form method="POST">
                    <textarea name="bio" rows="3" placeholder="Kendinizden bahsedin..."><?= htmlspecialchars($user['bio'] ?? '') ?></textarea>
                    <button type="submit" name="update_bio" class="btn-save">Biyografiyi Güncelle</button>
                </form>
            </div>
            <br>
            <br>
            <div class="file-input">
                <h3>Profil Fotoğrafı</h3>
                <form method="POST" enctype="multipart/form-data">
                    <label class="file-label">
                        📁 Fotoğraf Seç
                        <input type="file" name="profile_image" accept="image/*" onchange="this.form.submit()" style="display:none;">
                    </label>
                </form>
            </div>
        </div>
        
        <div class="section">
            <h3>❤️ Beğendiğim Şehirler</h3>
            <?php if(count($likedCities) > 0): ?>
                <?php foreach($likedCities as $city): ?>
                    <a href="city.php?id=<?= $city['id'] ?>" class="city-tag">
                        <?= htmlspecialchars($city['name']) ?>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Henüz hiç şehir beğenmediniz.</p>
            <?php endif; ?>
        </div>
        
        <div class="section">
            <h3>💬 Yorumlarım</h3>
            <?php if(count($userComments) > 0): ?>
                <?php foreach($userComments as $comment): ?>
                    <div class="comment-mini">
                        <strong><a href="city.php?id=<?= $comment['city_id'] ?>"><?= htmlspecialchars($comment['city_name']) ?></a></strong>
                        <div>
                            <?php for($i = 1; $i <= 5; $i++): ?>
                                <?= $i <= $comment['rating'] ? '⭐' : '☆' ?>
                            <?php endfor; ?>
                        </div>
                        <p><?= nl2br(htmlspecialchars(substr($comment['comment'], 0, 150))) ?>...</p>
                        <small><?= date('d.m.Y', strtotime($comment['created_at'])) ?></small>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Henüz hiç yorum yapmadınız.</p>
            <?php endif; ?>
        </div>
    </div>
    <?php require_once 'partials/footer.php'; ?>
</body>
</html>