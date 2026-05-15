# Collaborative Notes - Real-time Note Sharing

Aplikasi catatan kolaboratif berbasis web yang memungkinkan pengguna untuk membuat, mengedit, dan menghapus catatan secara real-time. Dibangun dengan fokus pada sinkronisasi instan antar pengguna menggunakan Laravel Reverb.

## Fitur Utama

* **Real-time Collaboration**: Perubahan konten catatan tersinkronisasi secara otomatis tanpa perlu refresh halaman.
* **Presence Cursor**: Fitur kursor interaktif yang menunjukkan posisi mouse pengguna lain di area kerja secara real-time.
* **Smart Filter & Search**: Pencarian catatan berdasarkan judul/isi dan filter tanggal melalui kalender yang responsif.
* **Instant Note Addition**: Penambahan catatan baru langsung muncul di semua perangkat yang terhubung.
* **Responsive Design**: Antarmuka bersih dan modern menggunakan Tailwind CSS.

## Spesifikasi Teknis

* **Framework**: Laravel 12.x
* **Bahasa Pemrograman**: PHP 8.2+
* **Database**: MySQL / MariaDB
* **Real-time Server**: Laravel Reverb
* **Frontend**: Blade Templating & Tailwind CSS
* **State Management**: Laravel Echo & Pusher (Reverb Protocol)

## Cara Instalasi

1.  **Clone Repositori**
    ```bash
    git clone https://github.com/tasykiaananda/Project-Collaborative.git
    cd Project-Collaborative
    ```

2.  **Instal Dependensi PHP**
    ```bash
    composer install
    ```

3.  **Instal Dependensi Frontend**
    ```bash
    npm install && npm run build
    ```

4.  **Konfigurasi Environment**
    Salin file `.env.example` menjadi `.env` dan sesuaikan pengaturan database serta Reverb Anda.
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

5.  **Migrasi Database**
    ```bash
    php artisan migrate
    ```

6.  **Jalankan Aplikasi**
    Buka dua terminal:
    * Terminal 1: `php artisan serve`
    * Terminal 2: `php artisan reverb:start`

## Struktur Database

Tabel utama yang digunakan dalam proyek ini adalah `notes` yang menyimpan:
* `user_id`: Identitas pembuat catatan.
* `title`: Judul catatan.
* `content`: Isi detail catatan.
* `timestamps`: Waktu pembuatan dan pembaruan.

--- 
Dikembangkan oleh **Tasykia Ananda** - Prodi Sistem Informasi, Universitas Malikussaleh.