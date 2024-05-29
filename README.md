# Smart Building Management System 2

Smart BMS by IoT Lab UNS merupakan demo kit yang merepresentasikan sebuah bangunan cerdas berbasis IoT. Perangkat-perangkat elektronis pada ruangan dapat dikontrol dari jarak jauh. Dapat memantau energi yang digunakan serta melihat perkiraan jumlah tagihannya.

## What's different?

Versi ini adalah pengembangan versi iotlab-uns.com/smart-bms. Dengan beberapa penyesuaian, yaitu :
| Semso Demo 2022 | Smart-Office 2023|
| :-------------: |:-------------:|
| Menggunakan 2 Node MCU, 1 Monitor & 1 Control | Hanya 1 NodeMCU untuk Monitor dan Control|
| API menyederhanakan dari smart-bms | Hanya ada 2 API, 1 monitor dan 1 control|
| NodeMCU Control membaca data dari API terpisah | NodeMCU selalu membaca API kontrol, tetapi setiap 2 menit mengirimkan data monitor dan mendapat return berupa state control |
| Tabel tiap sensor dipisah-pisah | Tabel dijadikan satu untuk mempermudah pembacaan control ESP |
| Perhitungan energi dari web | Menerima data energi dari kWh meter agar akurat |

## Installation

### Pre Requirements

-   PHP 7.3 - 8.1 [8 is recommended]
-   MySQL 5.0

### Steps

1. Clone repo ini
    ```
    git clone https://github.com/SemarIoT/smart-office-2023.git
    ```
2. Pindah ke folder website dengan memakai terminal (GitBash / Powershell)
    ```
    cd smart-office-2023
    cd website
    ```
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