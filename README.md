Urutan Instalasi
1. Clone repository
2. Jalankan 'composer install'
3. Buat database lalu sesuaikan config '.env' atau 'config/database.php' dengan pengaturan database yang telah dibuat
4. Jalankan 'php artisan migrate'
5. Jalankan seeder secara berurutan
    <br>a. 'php artisan db:seed --class=Role'
    <br>b. 'php artisan db:seed --class=Menu'
    <br>c. 'php artisan db:seed --class=RoleAccess'
    <br>d. 'php artisan db:seed --class=User'

6. Extrak sql wilayahs.sql

7. Sekarang Anda bisa membuka project di browser dengan url "localhost/[namaproject]/public"
    <br>
    List akun yang telah ditambahkan : 
    <br><br>username/email  : superadmin@mail.com
    <br>password            : 12345678

    <br><br>username/email  : admin@mail.com
    <br>password            : 12345678

    <br><br>username/email  : operator@mail.com
    <br>password            : 12345678