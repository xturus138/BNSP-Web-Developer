# Inkubator Startup - BNSP Web Developer Project

Sistem Inkubator Startup dikembangkan sebagai bagian dari tugas sertifikasi BNSP Web Developer. Aplikasi ini mengelola registrasi tenant, monitoring startup, dan manajemen proposal.

## Prasyarat (Requirements)

Sebelum menjalankan proyek, pastikan Anda telah menginstal:

- PHP >= 8.2 (Direkomendasikan 8.4)
- Composer
- Node.js & NPM
- MySQL/MariaDB

## Langkah Instalasi

1. **Clone Repositori**

    ```bash
    git clone <url-repository>
    cd inkubator
    ```

2. **Instal Dependensi PHP**

    ```bash
    composer install
    ```

3. **Instal Dependensi Frontend**

    ```bash
    npm install
    ```

4. **Konfigurasi Environment**
   Salin file `.env.example` menjadi `.env`:

    ```bash
    cp .env.example .env
    ```

    Buka file `.env` dan sesuaikan konfigurasi database Anda:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=dbinkubator
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5. **Generate App Key**

    ```bash
    php artisan key:generate
    ```

6. **Migrasi & Seed Database**
   Pastikan database `dbinkubator` sudah dibuat di MySQL Anda, lalu jalankan:
    ```bash
    php artisan migrate --seed
    ```

## Menjalankan Aplikasi

Anda dapat menjalankan server backend dan bundle frontend secara bersamaan menggunakan perintah berikut:

```bash
composer run dev
```

Atau jalankan secara terpisah:

- **Server Backend**: `php artisan serve`
- **Frontend (Vite)**: `npm run dev`

Aplikasi akan berjalan di [http://localhost:8000](http://localhost:8000).

## Fitur Utama

- **Autentikasi**: Login Multi-role (Admin & Tenant).
- **Monitoring**: Dashboard admin untuk memantau resource server dan kesehatan database.
- **Manajemen Tenant**: Pendaftaran, verifikasi, dan monitoring progres startup.
- **UX**: Notifikasi real-time dan feedback visual yang user-friendly.

## Lisensi

Proyek ini dilisensikan di bawah [MIT license](https://opensource.org/licenses/MIT).
