# SBMS Gedung 4 Fakultas Teknik
Untuk monitoring dan controlling panel SDP Gedung 4 Fakultas Teknik

## Notes
- Project ini hanya untuk monitoring dan controlling komponen energi
- File-file sudah dicoba untuk seoptimal mungking (Hal-hal tidak terpakai seperti dht, firealarm, light, dll sudah dihapus)

## Installation

### Pre Requirements

-   PHP 7.3 - 8.1 [8 is recommended]
-   MySQL 5.0

### Steps

1. Clone repo ini
    ```
    git clone https://github.com/SemarIoT/sbms-ged-4.git
    ```
2. Buka terminal (GitBash / Powershell) pada direktori _'sbms-ged-4'_
3. Install dependensinya
    ```
    composer install
    ```
4. Copy file env.example dengan nama .env agar bisa dijalankan
    ```
    cp .env.example .env
    ```
5. Generate application key
    ```
    php artisan key:generate
    ```
6. Migrasi database (Cek pengaturan DB di env dan pastikan mysql atau xampp sudah berjalan)
    ```
    php artisan migrate
    ```
7. Jalankan local development server
    ```
    php artisan serve
    ```
8. Buka di website
    ```
    http://localhost:8000
    atau
    http://127.0.0.1:8000/
    ```

## Unused Table from smart-bms
- energy_outlet dan energy_outlet_master (sudah di energy_panel)
- lights (hanya 1 kontrol lampu di light_master saja)
- light_dimmers (tidak ada dimmer)
- plc_sipils