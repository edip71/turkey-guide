<?php
// Veritabanı bağlantısını footer'da da kullanabilmek için
if(!isset($pdo)) {
    require_once __DIR__ . '/../../config/database.php';
}

// İstatistikleri çek
try {
    $likeCount = $pdo->query("SELECT COUNT(*) FROM likes")->fetchColumn();
    $commentCount = $pdo->query("SELECT COUNT(*) FROM comments")->fetchColumn();
    $userCount = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
} catch(PDOException $e) {
    $likeCount = 0;
    $commentCount = 0;
    $userCount = 0;
}
?>

<style>
.site-footer {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
    color: #fff;
    margin-top: 3rem;
    padding: 3rem 0 0 0;
    font-family: 'Poppins', sans-serif;
}

.footer-container {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    padding: 0 2rem;
}

.footer-section h3 {
    font-size: 1.2rem;
    margin-bottom: 1rem;
    position: relative;
    display: inline-block;
}

.footer-section h3::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 50px;
    height: 2px;
    background: linear-gradient(45deg, #667eea, #764ba2);
    border-radius: 2px;
}

.footer-section p {
    line-height: 1.6;
    color: #ccc;
    font-size: 0.9rem;
}

.footer-section ul {
    list-style: none;
    padding: 0;
}

.footer-section ul li {
    margin-bottom: 0.5rem;
    color: #ccc;
    font-size: 0.9rem;
}

.footer-section ul li a {
    color: #ccc;
    text-decoration: none;
    transition: 0.3s;
}

.footer-section ul li a:hover {
    color: #667eea;
    padding-left: 5px;
}

.social-links {
    display: flex;
    gap: 1rem;
    margin-top: 1rem;
}

.social-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
    text-decoration: none;
    color: white;
    font-size: 1.2rem;
    transition: 0.3s;
}

.social-link:hover {
    background: linear-gradient(45deg, #667eea, #764ba2);
    transform: translateY(-3px);
}

.footer-bottom {
    text-align: center;
    padding: 1.5rem;
    margin-top: 2rem;
    border-top: 1px solid rgba(255,255,255,0.1);
    font-size: 0.8rem;
    color: #888;
}

.footer-bottom p {
    margin: 0.3rem 0;
}

@media (max-width: 768px) {
    .footer-container {
        grid-template-columns: 1fr;
        text-align: center;
    }
    
    .footer-section h3::after {
        left: 50%;
        transform: translateX(-50%);
    }
    
    .social-links {
        justify-content: center;
    }
}
</style>

<!-- Footer Başlangıcı -->
<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-section">
            <h3>🇹🇷 Türkiye'yi Tanıyalım</h3>
            <p>81 il, 81 güzellik. Türkiye'nin tüm şehirlerini keşfedin, yorum yapın ve beğenin.</p>
            <div class="social-links">
                <a href="#" class="social-link">📘</a>
                <a href="#" class="social-link">📷</a>
                <a href="#" class="social-link">🐦</a>
                <a href="#" class="social-link">💬</a>
            </div>
        </div>
        
        <div class="footer-section">
            <h3>🔗 Hızlı Bağlantılar</h3>
            <ul>
                <li><a href="index.php">Ana Sayfa</a></li>
                <li><a href="dashboard.php">Tüm Şehirler</a></li>
                <li><a href="profile.php">Profilim</a></li>
                <li><a href="#">Hakkımızda</a></li>
            </ul>
        </div>
        
        <div class="footer-section">
            <h3>📊 İstatistikler</h3>
            <ul>
                <li>🏙️ 81 Şehir</li>
                <li>❤️ <?php echo $likeCount; ?> Beğeni</li>
                <li>💬 <?php echo $commentCount; ?> Yorum</li>
                <li>👤 <?php echo $userCount; ?> Üye</li>
            </ul>
        </div>
        
        <div class="footer-section">
            <h3>📞 İletişim</h3>
            <ul>
                <li>📧 250408039@ostimteknik.edu.tr</li>
                <li>📞 0 (544) 270 65 76</li>
                <li>📍 Ankara, Türkiye</li>
            </ul>
        </div>
    </div>
    
    <div class="footer-bottom">
        <p>&copy; 2026 Türkiye'yi Tanıyalım - Tüm hakları saklıdır.</p>
        <p>Yazılım Geliştirme Teknolojileri BGT 132 Final Projesi | Edip Pehlivanlı</p>
    </div>
</footer>
<!-- Footer Bitişi -->