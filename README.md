Dokumentasi User - Aplikasi Website Sistem Peramalan Penjualan
1. Pendahuluan
Dokumentasi ini dibuat sebagai panduan untuk melakukan setup awal aplikasi website Sistem Peramalan Penjualan.
2. Persyaratan Sistem
Sebelum memulai, pastikan sistem Anda memiliki:
2.1 Untuk Laravel
•	PHP 8.1 atau versi terbaru
•	Composer
•	Database (MySQL, PostgreSQL, atau SQLite)
•	Web server (Apache/Nginx) atau menggunakan Laravel development server
2.2 Untuk Flask API
•	Python 3.11
•	pip (Python package manager)
•	Virtual environment (direkomendasikan)
3. Instalasi dan Konfigurasi Awal
3.1 Clone dan Install Laravel Dependencies 
# Clone repository
git clone [repository-url]
cd [project-directory]

# Install dependencies Laravel
composer install
npm install
3.2 Setup Flask API
3.2.1 Clone Repository dan Install Python Dependencies
# Clone repository
git clone [repository-url]
cd [project-directory]

# Buat virtual environment (direkomendasikan)
python -m venv venv

# Aktifkan virtual environment
# Windows:
venv\Scripts\activate
# Linux/Mac:
source venv/bin/activate

# Install dependencies Flask
pip install -r requirements.txt
3.2.2 Jalankan Flask API
# Pastikan virtual environment aktif
# Jalankan Flask API
python app.py
Flask API akan berjalan di http://127.0.0.1:5000
⚠️ PENTING: Flask API harus dijalankan terlebih dahulu sebelum menjalankan aplikasi Laravel.
3.3 Konfigurasi Environment Laravel
3.3 Konfigurasi Environment Laravel
1.	Salin file environment:
cp .env.example .env
2.	Generate application key:
php artisan key:generate
3.	Konfigurasi database di file .env:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=username_db
DB_PASSWORD=password_db
3.4 Konfigurasi Akun Admin
Di file .env, tambahkan atau edit konfigurasi admin berikut:
ADMIN_NAME="Administrator"
ADMIN_EMAIL="admin@yourcompany.com"
ADMIN_PASSWORD="your-very-secure-password"
⚠️ PENTING:
•	Ganti admin@yourcompany.com dengan email yang valid
•	Ganti your-very-secure-password dengan password yang kuat
•	Gunakan kombinasi huruf besar, kecil, angka, dan simbol untuk password
4. Setup Database dan Admin
4.1 Migrasi Database
Jalankan migrasi untuk membuat tabel yang diperlukan:
php artisan migrate
4.2 Setup Admin Pertama Kali
Setelah konfigurasi .env selesai, jalankan command berikut untuk membuat akun admin:
php artisan admin:setup
Command ini akan:
•	Membaca konfigurasi admin dari file .env
•	Membuat user administrator dengan role admin
•	Memberikan semua permissions yang diperlukan
4.3 Verifikasi Setup
Untuk memverifikasi bahwa admin berhasil dibuat:
php artisan tinker
Kemudian jalankan:
User::where('email', env('ADMIN_EMAIL'))->first();

5. Menjalankan Aplikasi
5.1 Urutan Startup
PENTING: Ikuti urutan ini untuk menjalankan aplikasi:
5.1.1 Jalankan Flask API Terlebih Dahulu
# Pastikan berada di direktori project
cd [project-directory]

# Aktifkan virtual environment
# Windows:
venv\Scripts\activate
# Linux/Mac:
source venv/bin/activate

# Jalankan Flask API
python app.py
Flask API akan berjalan di http://127.0.0.1:5000
Biarkan terminal ini tetap terbuka - Flask API harus terus berjalan.
5.1.2 Jalankan Laravel (Terminal Baru)
Buka terminal baru dan pilih salah satu cara untuk menjalankan Laravel:
Opsi 1: Laravel Development Server (Paling Mudah)
# Pastikan berada di direktori project
cd [project-directory]

# Jalankan Laravel development server
php artisan serve
Laravel akan berjalan di http://127.0.0.1:8000
5.1.3 Jalankan Vite Development Server (Terminal Ketiga)
Buka terminal ketiga untuk menjalankan Vite (untuk asset compilation):
# Pastikan berada di direktori project
cd [project-directory]

# Jalankan Vite development server
npm run dev
Vite akan berjalan dan melakukan hot reload untuk CSS/JS changes.
⚠️ PENTING: Untuk development, Anda perlu menjalankan 3 terminal:
1.	Terminal 1: Flask API (python app.py)
2.	Terminal 2: Laravel server (php artisan serve)
3.	Terminal 3: Vite dev server (npm run dev)
Opsi 2: Apache (Perlu Virtual Host)
# Contoh konfigurasi virtual host di Apache
<VirtualHost *:80>
    ServerName laravel-app.local
    DocumentRoot /path/to/project/public
    
    <Directory /path/to/project/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
Opsi 3: Nginx (Perlu Server Block)
# Contoh konfigurasi server block di Nginx
server {
    listen 80;
    server_name laravel-app.local;
    root /path/to/project/public;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
Opsi 4: XAMPP/WAMP/MAMP
•	Copy project ke folder htdocs (XAMPP) atau www (WAMP)
•	Akses melalui http://localhost/project-name/public
•	Tetap perlu menjalankan npm run dev untuk asset compilation
Catatan: Untuk semua opsi web server, pastikan npm run dev tetap berjalan di background untuk proper asset loading.

5.3 Login sebagai Admin
1.	Buka browser dan akses aplikasi:
o	Laravel dev server: http://127.0.0.1:8000/login
o	Apache/Nginx: http://laravel-app.local/login (sesuai konfigurasi)
o	XAMPP/WAMP: http://localhost/project-name/public/login
2.	Masukkan kredensial admin:
o	Email: Sesuai dengan ADMIN_EMAIL di .env
o	Password: Sesuai dengan ADMIN_PASSWORD di .env
3.	Klik "Login"
5.4 Setelah Login
Setelah login berhasil, user akan diarahkan ke dashboard utama di:
•	http://127.0.0.1:8000/home (untuk Laravel dev server)
•	Atau sesuai dengan konfigurasi web server yang digunakan
5.5 Panel Admin
Admin dapat mengakses panel admin (jika ada) di http://127.0.0.1:8000/admin atau sesuai konfigurasi routing aplikasi.
5.6 Verifikasi Setup Lengkap
Untuk memastikan semua komponen berjalan dengan baik:
1.	Cek Flask API: http://127.0.0.1:5000 (harus menampilkan response API)
2.	Cek Laravel: http://127.0.0.1:8000 (harus menampilkan landing page)
3.	Cek Assets: Pastikan CSS/JS loading dengan benar (berkat npm run dev)
4.	Cek Login: Test login dengan kredensial admin
5.	Cek Home: Setelah login, pastikan redirect ke /home berfungsi

6. Troubleshooting
6.1 Error Umum Laravel
Error: "Database connection failed"
•	Periksa konfigurasi database di .env
•	Pastikan database service berjalan
•	Verifikasi username dan password database
Error: "Admin setup failed"
•	Pastikan migrasi database sudah dijalankan
•	Periksa konfigurasi admin di .env
•	Cek log Laravel di storage/logs/laravel.log
Error: "Permission denied"
•	Pastikan direktori storage dan bootstrap/cache writable:
chmod -R 775 storage bootstrap/cache
6.2 Error Flask API
Error: "ModuleNotFoundError"
•	Pastikan virtual environment aktif
•	Install ulang dependencies:
pip install -r requirements.txt
Error: "Address already in use"
•	Port 5000 sudah digunakan, matikan proses yang menggunakan port tersebut:
# Windows:
netstat -ano | findstr :5000
taskkill /PID <PID> /F

# Linux/Mac:
lsof -ti:5000 | xargs kill -9
Error: "Connection refused" dari Laravel ke Flask
•	Pastikan Flask API berjalan di http://127.0.0.1:5000
•	Periksa konfigurasi FLASK_API_URL di .env
•	Test Flask API secara langsung dengan curl
6.3 Error Integrasi
Error: "API prediction failed"
•	Periksa log Flask API di terminal
•	Periksa log Laravel di storage/logs/laravel.log
•	Pastikan format data yang dikirim sesuai dengan yang diharapkan Flask API
6.4 Command Debugging
Jika setup admin gagal, coba jalankan dengan verbose mode:
php artisan admin:setup --verbose

