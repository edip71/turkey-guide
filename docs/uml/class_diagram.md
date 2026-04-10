# Class Diagram

## Sınıflar

### User Sınıfı
- id, username, email, password, profile_image, bio
- register(), login(), updateProfile(), updateImage()

### City Sınıfı
- id, name, region, image, description, famous_for, history, location
- getAll(), getById(), getLikeCount(), isLikedByUser()

### Comment Sınıfı
- id, user_id, city_id, comment, rating
- add(), getByCityId()

### Like Sınıfı
- id, user_id, city_id
- toggle(), getCount(), isLiked()

## İlişkiler
- User → Comment (1 kullanıcı çok yorum yapar)
- City → Comment (1 şehre çok yorum yapılır)
- User → Like (1 kullanıcı çok şehir beğenir)
- City → Like (1 şehir çok beğeni alır)

## Kalıtım
BaseModel → User, City, Comment, Like (hepsi BaseModel'den türer)

## Encapsulation
Tüm sınıflarda private property'ler ve public getter/setter metotları var.