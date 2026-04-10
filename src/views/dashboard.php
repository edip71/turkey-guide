<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Geri tuşu ile eski sayfaya dönüldüğünde tekrar kontrol et
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Tarayıcının önbelleğe almasını engelle
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require_once '../config/database.php';

$stmt = $pdo->query("SELECT * FROM cities ORDER BY name");
$cities = $stmt->fetchAll();

$title = 'Şehirler';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Şehirler - Türkiye'yi Tanıyalım</title>
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
            position: sticky;
            top: 0;
            z-index: 1000;
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
        
        .dashboard-header { text-align: center; padding: 2rem; color: white; }
        .dashboard-header h1 { font-size: 2.5rem; margin-bottom: 0.5rem; }
        
        .search-box { max-width: 500px; margin: 2rem auto; }
        .search-box input {
            width: 100%;
            padding: 1rem 1.5rem;
            border: none;
            border-radius: 50px;
            font-size: 1rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        }
        .search-box input:focus { outline: none; transform: scale(1.02); }
        
        .cities-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 2rem;
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .city-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            transition: 0.3s;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .city-card:hover { transform: translateY(-10px); }
        
        .city-image {
            height: 200px;
            background-size: cover;
            background-position: center;
            position: relative;
        }
        .city-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, transparent, rgba(0,0,0,0.7));
        }
        
        .city-info { padding: 1.5rem; }
        .city-info h3 { font-size: 1.5rem; color: #333; margin-bottom: 0.5rem; }
        .region-badge {
            display: inline-block;
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            padding: 0.3rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            margin-bottom: 1rem;
        }
        .city-info p { color: #666; line-height: 1.6; margin-bottom: 1rem; }
        .detail-btn {
            display: inline-block;
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 25px;
            text-decoration: none;
            transition: 0.3s;
        }
        .detail-btn:hover { transform: scale(1.05); }
        
        .no-results { text-align: center; color: white; font-size: 1.5rem; padding: 3rem; }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .cities-grid { animation: fadeInUp 0.8s ease; }

                .welcome-message {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            padding: 1.5rem;
            margin: 1.5rem auto;
            max-width: 700px;
            animation: fadeInUp 0.8s ease;
        }

        .welcome-text {
            font-size: 1.8rem;
            font-weight: bold;
            background: linear-gradient(45deg, #ffd700, #ff8c00, #ff6347);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 0.5rem;
        }

        .welcome-subtext {
            font-size: 1rem;
            opacity: 0.9;
        }
                .region-filters {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 0.8rem;
            margin: 1.5rem 0;
        }
        
        .filter-btn {
            background: rgba(255,255,255,0.2);
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 50px;
            color: white;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 0.9rem;
        }
        
        .filter-btn:hover {
            background: rgba(255,255,255,0.4);
            transform: translateY(-2px);
        }
        
        .filter-btn.active {
            background: linear-gradient(45deg, #ffd700, #ff8c00);
            color: #333;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
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

    <div class="dashboard-header">
    <h1>Hoş Geldin, <?= htmlspecialchars($_SESSION['username']) ?>! 👋</h1>
    <div class="welcome-message">
        <p class="welcome-text">🇹🇷 <strong>Güzel Türkiye'mizin Birbirinden Değerli Şehirleri</strong> 🇹🇷</p>
        <p class="welcome-subtext">Her şehir ayrı bir hikaye, her köşe ayrı bir güzellik. Keşfetmeye hazır mısın?</p>
    </div>
    <div class="search-box">
        <input type="text" id="searchInput" placeholder="🔍 Şehir ara... (Örn: İstanbul, Ankara, İzmir)">
    </div>
    <!-- Bölge Filtreleme Butonları -->
<div class="region-filters">
    <button class="filter-btn active" data-region="all">🏠 Tümü</button>
    <button class="filter-btn" data-region="marmara">🌊 Marmara</button>
    <button class="filter-btn" data-region="ege">🌅 Ege</button>
    <button class="filter-btn" data-region="akdeniz">☀️ Akdeniz</button>
    <button class="filter-btn" data-region="İç anadolu">🏔️ İç Anadolu</button>
    <button class="filter-btn" data-region="karadeniz">🌲 Karadeniz</button>
    <button class="filter-btn" data-region="doğu anadolu">🗻 Doğu Anadolu</button>
    <button class="filter-btn" data-region="güneydoğu anadolu">🌙 Güneydoğu Anadolu</button>
</div>
</div>

    <div class="cities-grid" id="citiesGrid">
        <?php foreach($cities as $city): ?>
        <div class="city-card" data-name="<?= strtolower(htmlspecialchars($city['name'])) ?>" data-region="<?= strtolower(htmlspecialchars($city['region'])) ?>">
            <div class="city-image" style="background-image: url('../assets/images/cities/<?= $city['image'] ?? 'default.jpg' ?>')">
                <div class="city-overlay"></div>
            </div>
            <div class="city-info">
                <h3><?= htmlspecialchars($city['name']) ?></h3>
                <span class="region-badge">📍 <?= htmlspecialchars($city['region']) ?></span>
                <p><?= htmlspecialchars(substr($city['description'], 0, 100)) ?>...</p>
                <a href="city.php?id=<?= $city['id'] ?>" class="detail-btn">Detayları Gör →</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let value = this.value.toLowerCase();
            let cards = document.querySelectorAll('.city-card');
            let visibleCount = 0;
            
            cards.forEach(card => {
                let name = card.getAttribute('data-name');
                if(name.includes(value)) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });
            
            let noResultMsg = document.querySelector('.no-results');
            if(visibleCount === 0) {
                if(!noResultMsg) {
                    let msg = document.createElement('div');
                    msg.className = 'no-results';
                    msg.innerHTML = '😔 Aradığınız şehir bulunamadı!';
                    document.getElementById('citiesGrid').after(msg);
                }
            } else {
                if(noResultMsg) noResultMsg.remove();
            }
        });
        // Bölge filtreleme
let currentRegion = 'all';
let currentSearch = '';

function filterCities() {
    let cards = document.querySelectorAll('.city-card');
    let visibleCount = 0;
    
    cards.forEach(card => {
        let cityName = card.getAttribute('data-name') || '';
        let cityRegion = card.getAttribute('data-region') || '';
        
        let matchesSearch = cityName.includes(currentSearch);
        let matchesRegion = (currentRegion === 'all') || (cityRegion === currentRegion);
        
        if(matchesSearch && matchesRegion) {
            card.style.display = 'block';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });
    
        // Sonuç yoksa mesaj göster
        let noResultMsg = document.querySelector('.no-results');
        if(visibleCount === 0) {
            if(!noResultMsg) {
                let msg = document.createElement('div');
                msg.className = 'no-results';
                msg.innerHTML = '😔 Bu bölgede veya kriterde şehir bulunamadı!';
                document.getElementById('citiesGrid').after(msg);
            }
        } else {
            if(noResultMsg) noResultMsg.remove();
        }
    }

    // Arama inputu için
    document.getElementById('searchInput').addEventListener('keyup', function() {
        currentSearch = this.value.toLowerCase();
        filterCities();
    });

    // Bölge butonları için
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            currentRegion = this.getAttribute('data-region');
            filterCities();
        });
    });
    </script>
    <?php require_once 'partials/footer.php'; ?>
</body>
</html>