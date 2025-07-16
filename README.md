# **Ringkasan**

Ini adalah API Sistem Manajemen Inventaris berbasis Laravel yang menyediakan fungsionalitas komprehensif untuk melacak produk, lokasi, pergerakan stok (mutasi), dan aktivitas pengguna. Sistem ini dirancang untuk menangani operasi inventaris yang kompleks dengan autentikasi dan otorisasi yang tepat.

## Dokumentasi API
https://www.postman.com/security-architect-13980626/mikli-oktarianto/documentation/wdnkwz3/seleksi-backend-mikli-oktarianto

## **Fitur Utama**

* **Manajemen Produk**: Lacak produk dengan detail seperti kode, kategori, harga, dan satuan.  
* **Manajemen Lokasi**: Kelola beberapa lokasi penyimpanan lengkap dengan koordinat.  
* **Pelacakan Stok**: Catat semua pergerakan stok (masuk, keluar, transfer).  
* **Manajemen Pengguna**: Autentikasi aman dengan kontrol akses berbasis peran.  
* **Pelaporan**: Hasilkan laporan tingkat stok, pergerakan, dan utilisasi lokasi.  
* **RESTful API**: Endpoint berbasis JSON dengan kode status HTTP yang sesuai.

## **Kebutuhan Sistem**

* PHP 8.1+  
* Composer 2.0+  
* PostgreSQL 12+ (atau MySQL 8+)  
* Laravel 10+

## **Instalasi**

1. **Clone repository:**  
   git clone https://github.com/orymikoto/seleksi-backend-mikli-oktarianto.git
   cd seleksi-backend-mikli-oktarianto

2. **Install dependensi:**  
   composer install

3. **Buat dan konfigurasikan file** .env**:**  
   cp .env.example .env

4. **Generate kunci aplikasi:**  
   php artisan key:generate

5. **Konfigurasikan koneksi database di** .env**:**  
   DB\_CONNECTION=pgsql  
   DB\_HOST=127.0.0.1  
   DB\_PORT=5432  
   DB\_DATABASE=inventory\_db  
   DB\_USERNAME=postgres  
   DB\_PASSWORD=your\_password

6. **Jalankan migrasi dan seeder:**  
   php artisan migrate \--seed

## **Menjalankan Aplikasi**

1. **Mulai server pengembangan:**  
   php artisan serve

   API akan tersedia di http://localhost:8000/api

## **Dokumentasi API**

### **Autentikasi**

Semua endpoint (kecuali login) memerlukan autentikasi dengan *Bearer Token*.

**Login**

POST /api/login

**Request:**

{  
    "email": "mikli@clavata.com",  
    "password": "mikli123"  
}

**Response:**

{
    "success": true,
    "token": "12|owMFwTKakNTof0a5TwM8JDQDcKqnw7e6U1kYx15u8fbd23d9",
    "user": {
        "id": 1,
        "name": "Mikli Tester",
        "email": "mikli@clavata.com",
        "email_verified_at": "2025-07-15T23:04:41.000000Z",
        "created_at": "2025-07-15T23:04:41.000000Z",
        "updated_at": "2025-07-15T23:04:41.000000Z"
    }
}

### **Endpoint Utama**

**Produk**

GET    /api/produk       \- Menampilkan semua produk  
POST   /api/produk       \- Membuat produk baru  
GET    /api/produk/search?query=value  \- Search Produk
GET    /api/produk/low-stock  \- Mendapatkan produk yang memiliki stok sedikit
GET    /api/produk/{id}  \- Mendapatkan detail produk  
PUT    /api/produk/{id}  \- Memperbarui produk  
DELETE /api/produk/{id}  \- Menghapus produk

**Lokasi**

GET    /api/lokasi       \- Menampilkan semua lokasi  
POST   /api/lokasi       \- Membuat lokasi baru  
GET    /api/lokasi/search?query=value  \- Search Lokasi 
GET    /api/lokasi/{id}  \- Mendapatkan detail lokasi  
PUT    /api/lokasi/{id}  \- Memperbarui lokasi  
DELETE /api/lokasi/{id}  \- Menghapus lokasi

**Pergerakan Stok (Mutasi)**

GET    /api/mutasi                  \- Menampilkan semua pergerakan stok  
POST   /api/mutasi                  \- Mencatat pergerakan baru  
POST   /api/mutasi/transfer         \- Transfer stok antar lokasi  
GET    /api/mutasi/{id}             \- Mendapatkan detail pergerakan  
DELETE /api/mutasi/{id}             \- Menghapus catatan pergerakan  
GET    /api/mutasi/user/{id}      \- Mendapatkan pergerakan berdasarkan pengguna  
GET    /api/mutasi/produk/{id}    \- Mendapatkan pergerakan berdasarkan produk

### **Contoh Request**

**Membuat Produk**

curl \-X POST http://localhost:8000/api/produk \\  
  \-H "Authorization: Bearer token\_anda" \\  
  \-H "Content-Type: application/json" \\  
  \-d '{  
    "kode\_produk": "PRD-001",  
    "nama\_produk": "Laptop Gaming",  
    "kategori\_id": 1,  
    "harga": 15000000,  
    "satuan": "unit"  
  }'

**Transfer Stok**

curl \-X POST http://localhost:8000/api/mutasi/transfer \\  
  \-H "Authorization: Bearer token\_anda" \\  
  \-H "Content-Type: application/json" \\  
  \-d '{  
    "produk\_id": 1,  
    "lokasi\_asal\_id": 1,  
    "lokasi\_tujuan\_id": 2,  
    "jumlah": 5,  
    "keterangan": "Transfer ke cabang"  
  }'

### **Skema Database**

Tabel kunci:

* **produks**: Data master produk  
* **lokasis**: Informasi lokasi  
* **produk\_lokasi**: Tingkat stok per lokasi (tabel pivot)  
* **mutasis**: Semua catatan pergerakan stok  
* **users**: Pengguna sistem

### **Deployment**

Untuk deployment ke produksi:

1. Konfigurasikan koneksi database yang benar.  
2. Atur APP\_ENV=production di .env.  
3. contoh .env ada pada .env example saya sudah memberikan contoh untuk konfigurasi umum pada postgresql, mysql dan sqlite
4. Optimalkan aplikasi:  
   php artisan optimize

5. Siapkan *queue worker* untuk pekerjaan latar belakang (jika ada).

### **Lisensi**

Proyek ini dilisensikan di bawah Lisensi MIT.
