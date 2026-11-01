# Aplikasi Pelaporan dan Pemantauan Karhutla

Mini Project Proyek 3 - D3 Teknik Informatika, Kasus B.

## Identitas
- Nama: Immanoel
- NIM: 251511042
- Kelas: 2B-D3

## Kebutuhan Environment
- PHP >= 8.2, Composer, Laravel >= 13
- Node.js & npm
- MySQL(XAMPP)

## Instalasi
```bash
git clone <https://github.com/tiranui/Mini_Project_3_CaseB>
cd karhutla-app
composer install
npm install
npm run build
copy .env.example .env
php artisan key:generate
```

## Konfigurasi Database
Buat database `karhutla`, lalu ubah di `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=karhutla
DB_USERNAME=root
DB_PASSWORD=
```

## Migration & Seeding
```bash
php artisan migrate:fresh --seed
```

## Menjalankan Aplikasi
```bash
php artisan serve
```
Buka http://127.0.0.1:8000

## Akun Demo (password: `password`)
| Role | Email |
|---|---|
| Pelapor | pelapor@example.com, pelapor2@example.com |
| Relawan Pemantau | relawan@example.com |
| Koordinator Relawan | koordinator@example.com |

## Alur Status
menunggu_review -> sedang_ditinjau -> perlu_tindakan -> selesai