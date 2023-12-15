<p align="center"><a href="https://migoda.com" target="_blank"><img src="https://migoda.com/front/assets/images/logo-header.png"></a></p>

<p align="center">
<a href="https://beta.migoda.com"><img src="https://github.com/pars-design/migoda/workflows/CI%20Code%20Checks/badge.svg?branch=master" alt="Beta Status"></a>
<a href="https://migoda.com"><img src="https://github.com/pars-design/migoda/workflows/CI%20&%20CD/badge.svg" alt="Production Status"></a>
</p>


---

### Kurulum

- **".env.example"** dosyasının bir kopyasını **".env"** olarak oluşturunuz.
- Oluşturduğunuz **".env"** dosyasındaki veritabanı ayarlarını doğru şekilde yaptığınızdan emin olunuz.
- `composer install`
- `php artisan db:wipe` (Opsiyonel) **UYARI:** Eğer bu adımı uygularsanız hali hazırdaki veritabanı sıfırlanacaktır.
- `php artisan migrate`
- Sizinle paylaşılan güncel database dosyasını manuel olarak import ediyoruz.
- `yarn install`
- `yarn dev`

### Front-end geliştirme için

- `yarn watch`

### Notlar

- Admin tarafı için css yazılacağı zaman lütfen **"public/admin/assets/scss"** içindeki **"custom.scss"** dosyasında
  yapınız. Webpack otomatik compile edecektir.
- Ön yüze css yazmak içinde **"resources/styles/partials"** içinde yer alan **"_custom.scss"** veya **"
  resources/styles/partials"** içinde yer alan **".css"** dosyalarında yapabilirsiniz. Yine webpack otomatik compile
  edecektir.
###Dil senkronizasyonu
  Dil senkronizasyonu için "git diff" kullanılmalıdır. Adım adım aşağıda nasıl dil senkronizasyonu yapacağımızı anlatıyor olacağım.

#### Nasıl dil senkronizasyonu yapabilirim
- `php artisan translation_sheet:prepare` komutu ile localdeki dosyalar hazırlanır ve "prepare local languages files" açıklaması ile commit edilir.
- `php artisan translation_sheet:pull` komutu ile "google sheet" üzerindeki güncel dil dosyaları çekilir.
- "Google sheet" üzerindeki tüm dil değişkenleri bizim değişkenlerimizi ezeceği için, daha önce "prepare local languages files" açıklaması ile yaptığımız commit'i güncel dosyalar ile diff ediyoruz.
Diff işlemi sırasında eksik olan dosyaları alıp, güncellenmiş dosyalara dokunmuyoruz. Böylelikle localde yapılan değişiklikleri kaybetmemiş ve müşterinin içeriğini ezmemiş oluyoruz.
- Tüm değişiklikleri "pull languages files" açıklaması ile commit atıyoruz.
- `php artisan translation_sheet:prepare` komutu ile dosyaları tekrar hazırlıyoruz ve `php artisan translation_sheet:push` komutu ile güncel dil dosyalarını google sheet'e yazıyoruz.
- Son olarak "01 Haziran 2021 Dil Güncelleştirmesi" gibi bir açıklama ile commit atıp, geliştirmelerimizi push ediyoruz.
  

#### Dil paketi komutları
  `php artisan translation_sheet:pull`  
  Google sheet üzerinden güncel tabloları al ve local dil dosyalarının üstüne yaz.  
  `php artisan translation_sheet:push`  
  Local üzerindeki güncel dil verilerini google sheet'e gönder.  
  `php artisan translation_sheet:lock`  
  Google sheet dosyasını kilitle ve aç.  
  `php artisan translation_sheet:open`  
  Google sheet adresini göster / aç.
  `php artisan translation_sheet:prepare`  
  Çeviri dosyalarını hazırla. (Dil dosyasına ekleme veya çıkarma yaptıktan sonra mutlaka bu komutu çalıştıralım commit
  atmadan önce)

---

### extra stuff

https://quickadminpanel.com/blog/stripe-payments-in-laravel-the-ultimate-guide/
