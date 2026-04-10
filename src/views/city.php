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

$city_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare("SELECT * FROM cities WHERE id = ?");
$stmt->execute([$city_id]);
$city = $stmt->fetch();

if(!$city) {
    die("Şehir bulunamadı!");
}

$likeStmt = $pdo->prepare("SELECT COUNT(*) FROM likes WHERE city_id = ?");
$likeStmt->execute([$city_id]);
$likeCount = $likeStmt->fetchColumn();

$userLikedStmt = $pdo->prepare("SELECT * FROM likes WHERE user_id = ? AND city_id = ?");
$userLikedStmt->execute([$_SESSION['user_id'], $city_id]);
$isLiked = $userLikedStmt->rowCount() > 0;

$commentStmt = $pdo->prepare("
    SELECT c.*, u.username, u.profile_image 
    FROM comments c 
    JOIN users u ON c.user_id = u.id 
    WHERE c.city_id = ? 
    ORDER BY c.created_at DESC
");
$commentStmt->execute([$city_id]);
$comments = $commentStmt->fetchAll();

$title = $city['name'] . ' - Şehir Rehberi';
?>
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

$city_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare("SELECT * FROM cities WHERE id = ?");
$stmt->execute([$city_id]);
$city = $stmt->fetch();

if(!$city) {
    die("Şehir bulunamadı!");
}

$likeStmt = $pdo->prepare("SELECT COUNT(*) FROM likes WHERE city_id = ?");
$likeStmt->execute([$city_id]);
$likeCount = $likeStmt->fetchColumn();

$userLikedStmt = $pdo->prepare("SELECT * FROM likes WHERE user_id = ? AND city_id = ?");
$userLikedStmt->execute([$_SESSION['user_id'], $city_id]);
$isLiked = $userLikedStmt->rowCount() > 0;

$commentStmt = $pdo->prepare("
    SELECT c.*, u.username, u.profile_image 
    FROM comments c 
    JOIN users u ON c.user_id = u.id 
    WHERE c.city_id = ? 
    ORDER BY c.created_at DESC
");
$commentStmt->execute([$city_id]);
$comments = $commentStmt->fetchAll();

$title = $city['name'] . ' - Şehir Rehberi';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($city['name']) ?> - Türkiye'yi Tanıyalım</title>
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
        flex-wrap: wrap;
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
    
    .city-hero {
        background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.7)), url('../assets/images/cities/<?= $city['image'] ?? 'default.jpg' ?>');
        background-size: cover;
        background-position: center;
        height: 350px;
        border-radius: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 1.5rem;
    }
    .city-hero h1 { font-size: 3.5rem; color: white; text-shadow: 2px 2px 10px rgba(0,0,0,0.5); }
    
    .city-content { background: white; border-radius: 30px; padding: 2rem; margin: 0 1.5rem 1.5rem 1.5rem; }
    
    /* İYİLEŞTİRİLMİŞ GRID - 2 SÜTUN */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    /* Tablet için */
    @media (max-width: 900px) {
        .info-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    /* Telefon için */
    @media (max-width: 600px) {
        .info-grid {
            grid-template-columns: 1fr;
        }
        .city-hero h1 { font-size: 2.5rem; }
        .city-hero { height: 250px; }
    }
    
    .info-card {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 20px;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .info-card h3 {
        color: #667eea;
        margin-bottom: 1rem;
        font-size: 1.2rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .info-card p {
        color: #555;
        line-height: 1.6;
        font-size: 0.95rem;
    }
    
    .map-btn {
        display: inline-block;
        background: #4285f4;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        text-decoration: none;
        font-size: 0.85rem;
        margin-top: 0.8rem;
        transition: 0.3s;
    }
    .map-btn:hover {
        background: #3367d6;
        transform: scale(1.02);
    }
    
    .like-section {
        margin-bottom: 2rem;
        padding: 1rem 1.5rem;
        background: #f8f9fa;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .like-count {
        font-size: 1.1rem;
    }
    .like-count strong {
        color: #667eea;
        font-size: 1.3rem;
    }
    .like-btn-large {
        background: linear-gradient(45deg, #667eea, #764ba2);
        color: white;
        border: none;
        border-radius: 50px;
        padding: 0.7rem 1.8rem;
        cursor: pointer;
        font-size: 1rem;
        transition: 0.3s;
    }
    .like-btn-large:hover { transform: scale(1.05); }
    
    .comments-section { margin-top: 2rem; }
    .comments-section h2 {
        margin-bottom: 1.5rem;
        font-size: 1.5rem;
        color: #333;
    }
    
    .comment-form {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 20px;
        margin-bottom: 2rem;
    }
    .comment-form h3 { margin-bottom: 1rem; color: #333; }
    
    .rating-stars {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    .rating-stars input { display: none; }
    .rating-stars label {
        font-size: 1.8rem;
        color: #ddd;
        cursor: pointer;
        transition: 0.2s;
    }
    .rating-stars label:hover,
    .rating-stars label:hover ~ label,
    .rating-stars input:checked ~ label { color: #ffc107; }
    
    .comment-form textarea {
        width: 100%;
        padding: 1rem;
        border: 2px solid #eee;
        border-radius: 15px;
        font-family: inherit;
        margin: 1rem 0;
        resize: vertical;
    }
    .comment-form textarea:focus { outline: none; border-color: #667eea; }
    .comment-form button {
        background: linear-gradient(45deg, #667eea, #764ba2);
        color: white;
        border: none;
        padding: 0.7rem 1.8rem;
        border-radius: 25px;
        cursor: pointer;
        transition: 0.3s;
    }
    .comment-form button:hover { transform: scale(1.02); }
    
    .comment-item {
        border-bottom: 1px solid #eee;
        padding: 1rem;
        transition: background 0.3s;
    }
    .comment-item:hover { background: #fafafa; }
    .comment-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 0.5rem;
        flex-wrap: wrap;
    }
    .comment-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }
    .comment-username { font-weight: 600; color: #333; }
    .comment-rating { color: #ffc107; font-size: 0.9rem; }
    .comment-date { font-size: 0.75rem; color: #999; margin-left: auto; }
    .comment-item p { color: #555; line-height: 1.5; margin-top: 0.5rem; }
    
    .back-btn {
        display: inline-block;
        background: #6c757d;
        color: white;
        padding: 0.7rem 1.8rem;
        border-radius: 25px;
        text-decoration: none;
        margin-top: 2rem;
        transition: 0.3s;
    }
    .back-btn:hover {
        background: #5a6268;
        transform: translateX(-3px);
    }
    
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .city-hero, .city-content { animation: fadeInUp 0.6s ease; }
    
   .location-card {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 20px;
    margin-top: 1.5rem;
    margin-bottom: 1.5rem;
    transition: transform 0.3s, box-shadow 0.3s;
    grid-column: 1 / -1;
    text-align: center;
}
.location-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}
.location-card h3 {
    color: #667eea;
    margin-bottom: 1rem;
    font-size: 1.2rem;
}
.location-card p {
    color: #555;
    line-height: 1.6;
    margin-bottom: 1rem;
}
.map-btn {
    display: inline-block;
    background: #4285f4;
    color: white;
    padding: 0.6rem 1.5rem;
    border-radius: 50px;
    text-decoration: none;
    font-size: 0.9rem;
    transition: 0.3s;
}
.map-btn:hover {
    background: #3367d6;
    transform: scale(1.02);
}
.gallery-section {
    margin: 2rem 0;
}
.gallery-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    margin-top: 1rem;
}
.gallery-img {
    width: 100%;
    height: 400px;
    object-fit: cover;
    border-radius: 15px;
    cursor: pointer;
    transition: 0.3s;
}
.gallery-img:hover {
    transform: scale(1.02);
}
@media (max-width: 768px) {
    .gallery-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

.delete-comment-btn {
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 20px;
    padding: 0.3rem 0.8rem;
    font-size: 0.7rem;
    cursor: pointer;
    margin-left: auto;
    transition: 0.3s;
}

.delete-comment-btn:hover {
    background: #c82333;
    transform: scale(1.02);
}
@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.alert.success {
    background: #28a745;
    color: white;
    padding: 1rem 1.5rem;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.alert.error {
    background: #dc3545;
    color: white;
    padding: 1rem 1.5rem;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
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

    <div class="city-hero">
        <h1><?= htmlspecialchars($city['name']) ?></h1>
    </div>

    <div class="city-content">
        <div class="info-grid">
            <div class="info-card">
                <h3>📜 Tarihçe</h3>
                <p><?= nl2br(htmlspecialchars($city['history'] ?: 'Henüz bilgi eklenmemiş.')) ?></p>
            </div>

            <div class="info-card">
                <h3>🎯 Neyi Meşhur?</h3>
                <p><?= nl2br(htmlspecialchars($city['famous_for'] ?: 'Henüz bilgi eklenmemiş.')) ?></p>
            </div>

            <div class="info-card">
                <h3>🍽️ Ne Yenir?</h3>
                <p><?= nl2br(htmlspecialchars($city['cuisine'] ?: 'Henüz bilgi eklenmemiş.')) ?></p>
            </div>

            <div class="info-card">
                <h3>🎉 Festivaller</h3>
                <p><?= nl2br(htmlspecialchars($city['festivals'] ?: 'Henüz bilgi eklenmemiş.')) ?></p>
            </div>

            <div class="info-card">
                <h3>📅 En İyi Zaman</h3>
                <p><?= nl2br(htmlspecialchars($city['best_time'] ?: 'Henüz bilgi eklenmemiş.')) ?></p>
            </div>

            <div class="info-card">
                <h3>🚗 Ulaşım</h3>
                <p><?= nl2br(htmlspecialchars($city['transportation'] ?: 'Henüz bilgi eklenmemiş.')) ?></p>
            </div>

            
        </div>
        <!-- Fotoğraf Galerisi -->
<div class="gallery-section">
    <h3>📸 Şehirden Kareler</h3>
    <div class="gallery-grid">
        <img src="../assets/images/cities/<?= $city['image'] ?>" class="gallery-img">
        <img src="../assets/images/cities/<?= $city['image'] ?>" class="gallery-img">
        <img src="../assets/images/cities/<?= $city['image'] ?>" class="gallery-img">
    </div>
</div>
        <!-- Konum Kartı - Tam genişlik -->
<div class="location-card">
    <h3>📍 Konum</h3>
    <p><?= htmlspecialchars($city['location'] ?: 'Henüz bilgi eklenmemiş.') ?></p>
    <?php if($city['location']): ?>
    <div style="margin-top: 1rem;">
        <a href="https://www.google.com/maps/search/?api=1&query=<?= urlencode($city['location']) ?>" target="_blank" class="map-btn">
            🗺️ Google Haritalar'da Görüntüle
        </a>
    </div>
    <?php endif; ?>
</div>
        
        <div class="like-section">
            <div style="display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap;">
                <span style="font-size: 1.1rem;">❤️ <strong id="likeCount"><?= $likeCount ?></strong> kişi bu şehri beğendi</span>
                <button id="cityLikeBtn" class="like-btn-large" data-id="<?= $city['id'] ?>">
                    <?= $isLiked ? '❤️ Beğenmekten Vazgeç' : '🤍 Bu Şehri Beğen' ?>
                </button>
            </div>
        </div>
        
        <div class="comments-section">
            <h2>💬 Yorumlar ve Puanlar (<?= count($comments) ?> yorum)</h2>
            
            <div class="comment-form">
                <h3>Yorum Yap</h3>
                <form action="../controllers/CityController.php?action=add_comment" method="POST">
                    <input type="hidden" name="city_id" value="<?= $city['id'] ?>">
                    <div class="rating-stars">
                        <input type="radio" name="rating" value="5" id="star5"><label for="star5">★</label>
                        <input type="radio" name="rating" value="4" id="star4"><label for="star4">★</label>
                        <input type="radio" name="rating" value="3" id="star3"><label for="star3">★</label>
                        <input type="radio" name="rating" value="2" id="star2"><label for="star2">★</label>
                        <input type="radio" name="rating" value="1" id="star1"><label for="star1">★</label>
                    </div>
                    <textarea name="comment" rows="4" placeholder="<?= htmlspecialchars($city['name']) ?> hakkındaki düşünceleriniz..." required></textarea>
                    <button type="submit">✍️ Yorum Gönder</button>
                </form>
            </div>
            
            <?php if(count($comments) > 0): ?>
                <?php foreach($comments as $comment): ?>
                    <div class="comment-item" id="comment-<?= $comment['id'] ?>">
                        <div class="comment-header">
                            <img src="../assets/images/uploads/<?= $comment['profile_image'] ?? 'default.jpg' ?>" class="comment-avatar">
                            <span class="comment-username"><?= htmlspecialchars($comment['username']) ?></span>
                            <div class="comment-rating">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <?= $i <= $comment['rating'] ? '⭐' : '☆' ?>
                                <?php endfor; ?>
                            </div>
                            <span class="comment-date"><?= date('d.m.Y H:i', strtotime($comment['created_at'])) ?></span>
                                
                            <?php if($comment['user_id'] == $_SESSION['user_id']): ?>
                            <button class="delete-comment-btn" data-id="<?= $comment['id'] ?>" data-city-id="<?= $city['id'] ?>">
                                🗑️ Sil
                            </button>
                            <?php endif; ?>
                        </div>
                        <p><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
                    </div>
                    <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align: center; color: #999; padding: 2rem;">Henüz yorum yapılmamış. İlk yorumu siz yapın! 🎉</p>
            <?php endif; ?>
        </div>
        
        <a href="dashboard.php" class="detail-btn back-btn">← Tüm Şehirlere Dön</a>
    </div>

    <script>
        document.getElementById('cityLikeBtn').addEventListener('click', async function() {
            const cityId = this.getAttribute('data-id');
            
            try {
                const response = await fetch('../controllers/CityController.php?action=like', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: 'city_id=' + cityId
                });
                const result = await response.json();
                
                if(result.status === 'liked') {
                    this.innerHTML = '❤️ Beğenmekten Vazgeç';
                    document.getElementById('likeCount').innerText = result.total_likes;
                } else if(result.status === 'unliked') {
                    this.innerHTML = '🤍 Bu Şehri Beğen';
                    document.getElementById('likeCount').innerText = result.total_likes;
                }
            } catch(error) {
                console.error('Beğeni hatası:', error);
            }
        });
                // Yorum silme işlemi
        document.querySelectorAll('.delete-comment-btn').forEach(btn => {
            btn.addEventListener('click', async function(e) {
                e.preventDefault();

                if(!confirm('Bu yorumu silmek istediğinize emin misiniz?')) {
                    return;
                }

                const commentId = this.getAttribute('data-id');
                const cityId = this.getAttribute('data-city-id');

                try {
                    const response = await fetch('../controllers/CityController.php?action=delete_comment', {
                        method: 'POST',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        body: 'comment_id=' + commentId + '&city_id=' + cityId
                    });

                    const result = await response.json();

                    if(result.status === 'success') {
                        // Yorumu sayfadan kaldır
                        document.getElementById('comment-' + commentId).remove();

                        // Yorum sayısını güncelle (isteğe bağlı)
                        const commentCountSpan = document.querySelector('.comments-section h2');
                        if(commentCountSpan) {
                            let currentCount = parseInt(commentCountSpan.innerHTML.match(/\d+/)[0]);
                            commentCountSpan.innerHTML = commentCountSpan.innerHTML.replace(currentCount, currentCount - 1);
                        }

                        // Başarılı mesajı göster
                        showMessage('Yorum başarıyla silindi!', 'success');
                    } else {
                        showMessage(result.message || 'Bir hata oluştu!', 'error');
                    }
                } catch(error) {
                    console.error('Silme hatası:', error);
                    showMessage('Bir hata oluştu!', 'error');
                }
            });
        });

        // Mesaj gösterme fonksiyonu
        function showMessage(message, type) {
            let msgDiv = document.createElement('div');
            msgDiv.className = 'alert ' + type;
            msgDiv.innerHTML = message;
            msgDiv.style.position = 'fixed';
            msgDiv.style.top = '20px';
            msgDiv.style.right = '20px';
            msgDiv.style.zIndex = '9999';
            msgDiv.style.animation = 'slideIn 0.3s ease';
            document.body.appendChild(msgDiv);

            setTimeout(() => {
                msgDiv.remove();
            }, 3000);
        }
    </script>
    <?php require_once 'partials/footer.php'; ?>
</body>
</html>