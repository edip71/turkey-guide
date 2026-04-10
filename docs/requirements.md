# Gereksinim Analizi Dokümanı
## Türkiye'yi Tanıyalım - Şehir Rehberi Platformu

## 1. Proje Tanımı
Türkiye'nin 81 ilinin tanıtıldığı, kullanıcıların şehirleri beğenip yorum yapabildiği, 
profillerini kişiselleştirebildiği interaktif bir web platformu.

## 2. Fonksiyonel Gereksinimler

### 2.1 Kullanıcı Yönetimi
| ID | Gereksinim | Öncelik |
|----|-----------|---------|
| FR-01 | Kullanıcı kayıt olabilmeli (username, email, şifre) | Yüksek |
| FR-02 | Kullanıcı giriş yapabilmeli | Yüksek |
| FR-03 | Şifreler güvenli şekilde hash'lenmeli (bcrypt) | Yüksek |
| FR-04 | Kullanıcı profil fotoğrafı yükleyebilmeli | Orta |
| FR-05 | Kullanıcı biyografi ekleyebilmeli | Düşük |
| FR-06 | Kullanıcı çıkış yapabilmeli | Yüksek |

### 2.2 Şehir Rehberi
| ID | Gereksinim | Öncelik |
|----|-----------|---------|
| FR-07 | Ana sayfada tüm şehirler kart olarak listelenmeli | Yüksek |
| FR-08 | Şehir arama butonu ile filtreleme yapılabilmeli | Yüksek |
| FR-09 | Her şehrin detay sayfası olmalı | Yüksek |
| FR-10 | Şehir sayfasında tarihçe, meşhur yerler, konum gösterilmeli | Yüksek |
| FR-11 | Şehir fotoğrafları gösterilmeli | Orta |

### 2.3 Etkileşim Özellikleri
| ID | Gereksinim | Öncelik |
|----|-----------|---------|
| FR-12 | Kullanıcı şehirleri beğenebilmeli (AJAX ile anlık) | Yüksek |
| FR-13 | Kullanıcı şehirlere yorum yapabilmeli | Yüksek |
| FR-14 | Yorumlara 1-5 yıldız puanı verilebilmeli | Yüksek |
| FR-15 | Kullanıcı beğendiği şehirleri profilinde görebilmeli | Orta |
| FR-16 | Kullanıcı yorumlarını profilinde görebilmeli | Orta |

### 2.4 Güvenlik
| ID | Gereksinim | Öncelik |
|----|-----------|---------|
| FR-17 | SQL Injection önlenmeli (PDO kullanımı) | Yüksek |
| FR-18 | XSS saldırılarına karşı koruma (htmlspecialchars) | Yüksek |
| FR-19 | Oturum yönetimi (session) ile giriş kontrolü | Yüksek |
| FR-20 | Yetkisiz sayfalara erişim engellenmeli | Yüksek |

## 3. Fonksiyonel Olmayan Gereksinimler

| ID | Gereksinim | Hedef |
|----|-----------|-------|
| NFR-01 | Performans | Sayfa yüklenme süresi < 2 saniye |
| NFR-02 | Kullanılabilirlik | Mobil, tablet, bilgisayar uyumlu (responsive) |
| NFR-03 | Estetik | Animasyonlu, modern, profesyonel arayüz |
| NFR-04 | Kod Kalitesi | OOP prensiplerine uygun, yorum satırlı |
| NFR-05 | Hata Yönetimi | Try-catch ile tüm hatalar yakalanmalı |

## 4. Kullanıcı Rolleri ve Yetkileri

| Rol | Yetkileri |
|-----|-----------|
| **Ziyaretçi (Kayıtsız)** | - Ana sayfayı görüntüleyebilir<br>- Şehir kartlarını görebilir<br>- Giriş ve kayıt sayfalarını görebilir<br>- Yorum yapamaz, beğenemez |
| **Kullanıcı (Kayıtlı)** | - Tüm Ziyaretçi yetkilerine sahiptir<br>- Şehirleri beğenebilir<br>- Yorum yapabilir ve puanlayabilir<br>- Profilini düzenleyebilir<br>- Beğenilerini ve yorumlarını görebilir |

## 5. Sistem Kısıtları
- Web tarayıcısı üzerinden çalışır (Chrome, Firefox, Edge, Safari)
- İnternet bağlantısı gerektirir (yerel sunucu için localhost)
- PHP 7.4+ ve MySQL 5.7+ gerektirir