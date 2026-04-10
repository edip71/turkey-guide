# 🇹🇷 Türkiye'yi Tanıyalım

## Proje Adı
Türkiye'yi Tanıyalım

## Proje Amacı
Bu proje, Türkiye'nin 81 ilini tanıtan, kullanıcıların şehirleri beğenip yorum yapabildiği, 
profillerini kişiselleştirebildiği interaktif bir web platformudur.

## Kullanılan Teknolojiler
- **Backend:** PHP 8.2 (Nesne Yönelimli Programlama ile)
- **Database:** MySQL 8.0 (phpMyAdmin ile yönetim)
- **Frontend:** HTML5, CSS3, JavaScript (ES6)
- **Animasyonlar:** CSS Keyframes, Transform, Transition
- **AJAX:** Fetch API ile asenkron beğeni işlemleri
- **Versiyon Kontrol:** Git / GitHub

## Kurulum ve Çalıştırma Talimatları

### Gereksinimler
- XAMPP (veya WAMP/MAMP) kurulu olmalı
- PHP 7.4 veya üzeri
- MySQL 5.7 veya üzeri

### Adım Adım Kurulum

1. **XAMPP'ı başlatın** (Apache ve MySQL servislerini çalıştırın)

2. **phpMyAdmin'e gidin:** http://localhost/phpmyadmin

3. **Yeni veritabanı oluşturun:** `turkey_guide`

4. **database.sql dosyasını içe aktarın:**
   - phpMyAdmin'de "İçe Aktar" sekmesine tıklayın
   - database.sql dosyasını seçin
   - "Git" butonuna basın

5. **Proje dosyalarını kopyalayın:**
   - Tüm dosyaları `C:\xampp\htdocs\turkey_guide\` klasörüne koyun

6. **Tarayıcıda açın:** http://localhost/turkey_guide/src/

### Test Hesabı
- **Kullanıcı adı:** test
- **Şifre:** 123456

### Veya kendiniz kayıt olun:
- Kayıt Ol sayfasından yeni hesap oluşturabilirsiniz

## Proje Özellikleri
| Özellik | Açıklama |
|---------|----------|
| Kullanıcı Kayıt/Giriş | Şifreler hash'lenerek güvenli şekilde saklanır |
| 81 İl Kartları | Grid görünümde, arama filtresi ile |
| Şehir Detay Sayfası | Tarihçe, meşhur yerler, konum bilgileri |
| Yorum Sistemi | 5 yıldızlı puanlama ile birlikte |
| Beğeni Sistemi | AJAX ile anlık, sayfa yenilemeden |
| Kullanıcı Profili | Fotoğraf yükleme, biyografi düzenleme |
| Beğenilen Şehirler | Profil sayfasında listelenir |
| Yapılan Yorumlar | Profil sayfasında görüntülenir |
| Responsive Tasarım | Mobil, tablet ve bilgisayar uyumlu |
| Animasyonlu Arayüz | CSS keyframes, hover efektleri, geçişler |

## Klasör Yapısı 

```text
turkey_guide/
├── README.md
├── database.sql
├── index.php
├── docs/
│   ├── requirements.md
│   └── uml/
│       ├── use_case.md
│       └── class_diagram.md
└── src/
    ├── config/
    │   └── database.php
    ├── controllers/
    │   ├── AuthController.php
    │   └── CityController.php
    ├── models/
    │   ├── BaseModel.php
    │   ├── User.php
    │   ├── City.php
    │   ├── Comment.php
    │   └── Like.php
    ├── views/
    │   ├── partials/
    │   │   ├── header.php
    │   │   └── footer.php
    │   ├── index.php
    │   ├── login.php
    │   ├── register.php
    │   ├── dashboard.php
    │   ├── city.php
    │   └── profile.php
    ├── assets/
    │   ├── css/
    │   │   └── style.css
    │   ├── js/
    │   │   └── script.js
    │   └── images/
    │       ├── cities/
    │       └── uploads/
    └── index.php

---

## Geliştirici Notları
- Proje tamamen **Nesne Yönelimli Programlama** prensiplerine uygundur
- **Encapsulation** için private property + getter/setter kullanılmıştır
- **Kalıtım (Inheritance)** için BaseModel abstract sınıfı oluşturulmuştur
- **Polymorphism** için farklı modeller aynı save() metodunu override eder
- Tüm kullanıcı hataları **try-catch** blokları ile yönetilmiştir
- **Git** ile versiyonlanmıştır (5+ anlamlı commit)

## İletişim
Proje ile ilgili sorularınız için Edip Pehlivanlı'ya başvurabilirsiniz. 250408039@ostimteknik.edu.tr