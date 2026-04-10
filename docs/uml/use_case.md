# Use Case Diyagramı
## Türkiye'yi Tanıyalım Platformu

## Aktörler
1. **Ziyaretçi (Kayıtsız Kullanıcı)** - Sisteme kayıtlı olmayan kişi
2. **Kayıtlı Kullanıcı** - Sisteme giriş yapmış kişi

## Use Case Listesi

### Ziyaretçi İçin Use Case'ler:

#### UC-01: Kayıt Ol
- **Ön Koşul:** Ziyaretçi sisteme kayıtlı değil
- **Son Koşul:** Yeni kullanıcı hesabı oluşturulur
- **Temel Akış:**
  1. Ziyaretçi "Kayıt Ol" sayfasını açar
  2. Kullanıcı adı, e-posta ve şifre bilgilerini girer
  3. Sistem bilgileri doğrular
  4. Sistem yeni kullanıcıyı veritabanına kaydeder
  5. Sistem başarılı mesajı gösterir ve giriş sayfasına yönlendirir
- **Alternatif Akış:**
  - Kullanıcı adı veya e-posta zaten varsa → Hata mesajı gösterilir

#### UC-02: Giriş Yap
- **Ön Koşul:** Ziyaretçinin kayıtlı bir hesabı var
- **Son Koşul:** Kullanıcı oturum açar, ana sayfaya yönlendirilir
- **Temel Akış:**
  1. Ziyaretçi "Giriş Yap" sayfasını açar
  2. Kullanıcı adı ve şifreyi girer
  3. Sistem bilgileri doğrular
  4. Sistem oturum başlatır (session)
  5. Sistem dashboard sayfasına yönlendirir

#### UC-03: Şehirleri Görüntüle
- **Ön Koşul:** Yok
- **Son Koşul:** Şehirler listelenir
- **Temel Akış:**
  1. Ziyaretçi ana sayfaya gelir
  2. Sistem tüm şehirleri kartlar halinde gösterir
  3. Ziyaretçi arama kutusuna şehir adı yazabilir
  4. Sistem anında filtreleme yapar

---

### Kayıtlı Kullanıcı İçin Use Case'ler:

#### UC-04: Şehir Beğen
- **Ön Koşul:** Kullanıcı giriş yapmış
- **Son Koşul:** Şehir beğenilir veya beğeni kaldırılır
- **Temel Akış:**
  1. Kullanıcı şehir kartındaki beğeni butonuna tıklar
  2. Sistem AJAX ile beğeni durumunu günceller
  3. Butonun görünümü değişir (🤍 → ❤️)
  4. Beğeni sayısı anlık güncellenir

#### UC-05: Yorum Yap ve Puanla
- **Ön Koşul:** Kullanıcı giriş yapmış ve şehir detay sayfasında
- **Son Koşul:** Yorum ve puan veritabanına kaydedilir
- **Temel Akış:**
  1. Kullanıcı yorum yazmak istediği şehrin detay sayfasına gider
  2. Yorum metnini girer
  3. 1-5 yıldız arasında puan seçer
  4. "Yorum Gönder" butonuna tıklar
  5. Sistem yorumu ve puanı veritabanına kaydeder
  6. Sayfa yenilenir, yeni yorum listede görünür

#### UC-06: Profil Düzenle
- **Ön Koşul:** Kullanıcı giriş yapmış
- **Son Koşul:** Profil bilgileri güncellenir
- **Temel Akış:**
  1. Kullanıcı "Profilim" sayfasına gider
  2. Biyografi alanını düzenler
  3. Profil fotoğrafı yükler
  4. "Kaydet" butonuna tıklar
  5. Sistem bilgileri günceller

#### UC-07: Beğenilenleri Gör
- **Ön Koşul:** Kullanıcı giriş yapmış
- **Son Koşul:** Beğenilen şehirler listelenir
- **Temel Akış:**
  1. Kullanıcı "Profilim" sayfasına gider
  2. Sistem kullanıcının beğendiği tüm şehirleri listeler
  3. Kullanıcı herhangi bir şehre tıklayarak detayına gidebilir

#### UC-08: Çıkış Yap
- **Ön Koşul:** Kullanıcı giriş yapmış
- **Son Koşul:** Oturum sonlanır, giriş sayfasına yönlendirilir
- **Temel Akış:**
  1. Kullanıcı "Çıkış Yap" butonuna tıklar
  2. Sistem oturumu sonlandırır
  3. Sistem giriş sayfasına yönlendirir

## Use Case Diyagramı (Metin Temsili)

┌─────────────────────────────────────────────────────────────────────────────┐
│ Türkiye'yi Tanıyalım Platformu │
│ │
│ ┌─────────────┐ │
│ │ Ziyaretçi │ │
│ └──────┬──────┘ │
│ │ │
│ ├──────────────────▶ UC-01: Kayıt Ol │
│ ├──────────────────▶ UC-02: Giriş Yap │
│ └──────────────────▶ UC-03: Şehirleri Görüntüle │
│ │
│ ┌─────────────────┐ │
│ │ Kayıtlı Kullanıcı│ │
│ └────────┬────────┘ │
│ │ │
│ ├──────────────────▶ UC-04: Şehir Beğen │
│ ├──────────────────▶ UC-05: Yorum Yap ve Puanla │
│ ├──────────────────▶ UC-06: Profil Düzenle │
│ ├──────────────────▶ UC-07: Beğenilenleri Gör │
│ └──────────────────▶ UC-08: Çıkış Yap │
│ │
│ ┌─────────────────────────────────────────────────────────────────────┐ │
│ │ <<extend>> │ │
│ │ UC-05 (Yorum) ─────────────────────────────▶ UC-04 (Beğeni) │ │
│ └─────────────────────────────────────────────────────────────────────┘ │
└─────────────────────────────────────────────────────────────────────────────┘