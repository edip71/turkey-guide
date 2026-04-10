/**
 * Türkiye'yi Tanıyalım - JavaScript Dosyası
 * Animasyonlar, AJAX beğeni işlemleri ve arama filtresi
 */

// Sayfa yüklendiğinde çalışacak olaylar
document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Şehir arama filtresi
    const searchInput = document.getElementById('searchInput');
    if(searchInput) {
        searchInput.addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const cards = document.querySelectorAll('.city-card');
            let visibleCount = 0;
            
            cards.forEach(card => {
                const cityName = card.getAttribute('data-name');
                if(cityName && cityName.includes(searchValue)) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });
            
            // Sonuç yoksa mesaj göster
            const citiesGrid = document.getElementById('citiesGrid');
            let noResultMsg = document.querySelector('.no-results');
            
            if(visibleCount === 0) {
                if(!noResultMsg) {
                    const msg = document.createElement('div');
                    msg.className = 'no-results';
                    msg.innerHTML = '😔 Aradığınız şehir bulunamadı!';
                    citiesGrid.parentNode.insertBefore(msg, citiesGrid.nextSibling);
                }
            } else {
                if(noResultMsg) noResultMsg.remove();
            }
        });
    }
    
    // 2. Beğeni butonu AJAX işlemi
    const likeBtns = document.querySelectorAll('.like-btn');
    likeBtns.forEach(btn => {
        btn.addEventListener('click', async function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const cityId = this.getAttribute('data-id');
            
            try {
                const response = await fetch('../controllers/CityController.php?action=like', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'city_id=' + cityId
                });
                
                const result = await response.json();
                
                if(result.status === 'liked') {
                    this.innerHTML = '❤️';
                    this.classList.add('liked');
                } else if(result.status === 'unliked') {
                    this.innerHTML = '🤍';
                    this.classList.remove('liked');
                }
                
                // Beğeni sayısını güncelle (varsa)
                const likeCountSpan = document.getElementById('likeCount');
                if(likeCountSpan && result.total_likes !== undefined) {
                    likeCountSpan.textContent = result.total_likes;
                }
                
            } catch(error) {
                console.error('Beğeni hatası:', error);
            }
        });
    });
    
    // 3. Scroll animasyonu - görünürlüğe göre animasyon ekle
    const animateElements = document.querySelectorAll('.animate-on-scroll');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if(entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    
    animateElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'all 0.6s ease';
        observer.observe(el);
    });
    
    // 4. Yıldız puanlama sistemi (city.php sayfasında)
    const starInputs = document.querySelectorAll('.star-input');
    starInputs.forEach(star => {
        star.addEventListener('change', function() {
            const rating = this.value;
            const stars = document.querySelectorAll('.star-label');
            stars.forEach((starLabel, index) => {
                if(index < rating) {
                    starLabel.style.color = '#ffc107';
                } else {
                    starLabel.style.color = '#ddd';
                }
            });
        });
    });
    
    // 5. Form animasyonları
    const formInputs = document.querySelectorAll('input, textarea');
    formInputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.style.transform = 'scale(1.02)';
            this.style.transition = 'all 0.2s';
        });
        
        input.addEventListener('blur', function() {
            this.style.transform = 'scale(1)';
        });
    });
    
    // 6. Buton tıklama efekti
    const buttons = document.querySelectorAll('button, .btn, .detail-btn');
    buttons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            if(this.classList.contains('like-btn')) return;
            
            this.style.transform = 'scale(0.98)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 150);
        });
    });
    
    // 7. Konsola hoş geldin mesajı
    console.log('%c🇹🇷 Türkiye\'yi Tanıyalım\'a Hoş Geldiniz!', 'color: #667eea; font-size: 16px; font-weight: bold;');
    console.log('%c81 şehri keşfetmeye hazır mısın?', 'color: #764ba2; font-size: 14px;');
});

// 8. Sayfa yüklenme animasyonu
window.addEventListener('load', function() {
    document.body.style.opacity = '0';
    document.body.style.transition = 'opacity 0.5s ease';
    document.body.style.opacity = '1';
});