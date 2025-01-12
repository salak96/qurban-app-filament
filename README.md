# Tabungan Qurban

## Deskripsi
Tabungan Qurban adalah aplikasi yang membantu pengguna untuk menabung dan mengelola dana qurban mereka. Aplikasi ini dirancang untuk memudahkan proses perencanaan dan pencatatan tabungan qurban.

## Fitur
- Pencatatan transaksi tabungan
- Pengelolaan target dana qurban


## Instalasi
1. Clone repositori ini:
    ```bash
    git clone https://github.com/salak96/qurban-app-filament
    ```
2. Masuk ke direktori proyek:
    ```bash
    cd tabungan_qurban
    ```
3. Install dependencies:
    ```bash
    composer install
    npm install
    ```
4. Konfigurasi file `.env`:
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
5. Migrasi database:
    ```bash
    php artisan migrate
    ```

## Penggunaan
1. Jalankan server lokal:
    ```bash
    php artisan serve
    ```
2. Buka aplikasi di browser:
    ```
    http://localhost:8000
    ```

## Kontribusi
Jika Anda ingin berkontribusi, silakan fork repositori ini dan buat pull request dengan perubahan Anda.

## Lisensi
Proyek ini dilisensikan di bawah [MIT License](LICENSE).
