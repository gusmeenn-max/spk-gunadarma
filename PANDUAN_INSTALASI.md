# 📘 PANDUAN INSTALASI — SPK Pemilihan Jurusan Gunadarma

## ✅ Persyaratan Sistem (XAMPP)
| Kebutuhan | Versi Minimal |
|-----------|--------------|
| PHP | 8.1+ |
| MySQL | 5.7+ / MariaDB 10.3+ |
| Composer | 2.x |
| XAMPP | 8.x |
| Laravel | 10.x |

---

## 🚀 Langkah Instalasi

### STEP 1 — Copy Project ke htdocs

```
C:\xampp\htdocs\spk-gunadarma\
```

Pastikan seluruh folder project ada di sana.

---

### STEP 2 — Install Dependencies via Composer

Buka **Command Prompt** atau **Git Bash**, masuk ke folder project:

```bash
cd C:\xampp\htdocs\spk-gunadarma
composer install
```

Tunggu hingga selesai (butuh koneksi internet).

---

### STEP 3 — Setup File .env

```bash
# Copy file env
cp .env.example .env

# Generate application key
php artisan key:generate
```

Buka file `.env`, pastikan bagian database seperti ini:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=spk_gunadarma
DB_USERNAME=root
DB_PASSWORD=
```

> ⚠️ Jika XAMPP MySQL-mu menggunakan password, isi bagian `DB_PASSWORD`.

---

### STEP 4 — Buat Database di phpMyAdmin

1. Buka browser → `http://localhost/phpmyadmin`
2. Klik **New** di sidebar kiri
3. Nama database: `spk_gunadarma`
4. Collation: `utf8mb4_unicode_ci`
5. Klik **Create**

---

### STEP 5 — Jalankan Migrasi & Seeder

```bash
# Buat semua tabel
php artisan migrate

# Isi data awal (jurusan, kriteria, kuesioner, penilaian, admin)
php artisan db:seed
```

> Jika ada error, coba: `php artisan migrate:fresh --seed`

---

### STEP 6 — Jalankan Aplikasi

```bash
php artisan serve
```

Buka browser: **http://127.0.0.1:8000**

**ATAU** akses langsung via XAMPP: **http://localhost/spk-gunadarma/public**

---

## 🔐 Akun Default

| Role | Username | Password |
|------|----------|----------|
| Admin | `admin` | `admin123` |
| Mahasiswa (demo) | `demo` | `demo123` |

---

## 📁 Struktur Folder Penting

```
spk-gunadarma/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          ← Controller admin
│   │   │   ├── Auth/           ← Login, Register
│   │   │   └── User/           ← Controller mahasiswa
│   │   └── Middleware/
│   │       └── RoleMiddleware.php
│   ├── Models/                 ← Eloquent Models
│   └── Services/
│       └── TopsisService.php   ← ⭐ Engine TOPSIS
├── database/
│   ├── migrations/             ← Struktur tabel
│   └── seeders/
│       └── DatabaseSeeder.php  ← Data awal
├── resources/
│   └── views/
│       ├── admin/              ← Tampilan AdminLTE
│       ├── auth/               ← Login & Register
│       ├── user/               ← Tampilan mahasiswa
│       ├── layouts/
│       │   ├── admin.blade.php ← Layout AdminLTE
│       │   └── app.blade.php   ← Layout Bootstrap 5
│       └── welcome.blade.php   ← Landing page
└── routes/
    └── web.php                 ← Semua route
```

---

## 🔄 Alur Aplikasi

```
[Landing Page]
    ↓
[Register / Login]
    ↓ (mahasiswa)              ↓ (admin)
[Kuesioner 14 soal]      [Dashboard Admin]
    ↓                         ↓
[Proses TOPSIS]          [Kelola Jurusan/Kriteria/
    ↓                     Penilaian/Kuesioner/User]
[Hasil Ranking + Chart]
    ↓
[Download PDF]
[Simpan ke Histori]
```

---

## ⚙️ Algoritma TOPSIS (TopsisService.php)

```
Langkah 1: Bangun Matriks X  →  X[i][j] = nilai_standar × (input_user/5)
Langkah 2: Normalisasi       →  r_ij = x_ij / √(Σ x²_ij)
Langkah 3: Pembobotan        →  y_ij = w_j × r_ij
Langkah 4: Solusi Ideal      →  A+ dan A- (benefit/cost)
Langkah 5: Jarak Euclidean   →  D+_i dan D-_i
Langkah 6: Nilai Preferensi  →  V_i = D-_i / (D+_i + D-_i)
Langkah 7: Ranking           →  Urut V_i terbesar
```

---

## 🐛 Troubleshooting

### Error: `Class not found`
```bash
composer dump-autoload
```

### Error: `SQLSTATE[HY000] [1049] Unknown database`
→ Pastikan database `spk_gunadarma` sudah dibuat di phpMyAdmin.

### Error: `php_fileinfo extension` missing
→ Buka `php.ini` di XAMPP, hapus tanda `;` sebelum `extension=fileinfo`

### Error: `key too long` pada migrasi
→ Tambahkan di `app/Providers/AppServiceProvider.php`:
```php
use Illuminate\Support\Facades\Schema;
public function boot(): void {
    Schema::defaultStringLength(191);
}
```

### Halaman kosong / 500 Error
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### DomPDF error (PDF tidak muncul)
```bash
composer require barryvdh/laravel-dompdf
php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"
```

---

## 📝 Catatan untuk Skripsi (BAB III)

Data yang tersimpan di tabel `hasil` mencakup:
- `input_kuesioner` → Jawaban user (JSON)
- `matriks_keputusan` → Matriks X langkah 1
- `matriks_ternormalisasi` → Matriks r_ij langkah 2
- `matriks_terbobot` → Matriks y_ij langkah 3
- `solusi_ideal` → A+ dan A- langkah 4
- `detail_hasil` → D+, D-, V_i, ranking lengkap

Semua data ini bisa diambil untuk dijadikan **tabel perhitungan manual** di BAB III skripsi.

---

## 📞 Teknologi yang Digunakan

| Komponen | Teknologi |
|----------|-----------|
| Backend | PHP 8.1 + Laravel 10 |
| Database | MySQL (XAMPP) |
| Admin UI | AdminLTE 3.2 |
| User UI | Bootstrap 5.3 |
| Chart | Chart.js |
| PDF | barryvdh/laravel-dompdf |
| Server | XAMPP (Apache) |
