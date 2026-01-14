# 📦 Pantau Barang

**Platform Manajemen Stok & Toko Online**

Pantau Barang adalah aplikasi web yang membantu Anda mengelola inventaris, memantau stok, dan menjual produk secara online dengan mudah.

---

## 📋 Daftar Isi

-   [Fitur Utama](#-fitur-utama)
-   [Panduan Pengguna](#-panduan-pengguna)
    -   [Pendaftaran & Login](#1-pendaftaran--login)
    -   [Membuat Toko](#2-membuat-toko)
    -   [Dashboard](#3-dashboard)
    -   [Manajemen Kategori](#4-manajemen-kategori)
    -   [Manajemen Item/Barang](#5-manajemen-itembarang)
    -   [Stock Movement](#6-stock-movement-stok-masukkeluar)
    -   [Manajemen Order](#7-manajemen-order)
    -   [Profil Toko](#8-profil-toko)
-   [Panduan Super Admin](#-panduan-super-admin)
-   [Toko Online (Frontend)](#-toko-online-frontend)

---

## ✨ Fitur Utama

| Fitur                       | Deskripsi                                                |
| --------------------------- | -------------------------------------------------------- |
| 🏪 **Multi-Toko**           | Setiap pengguna dapat membuat dan mengelola toko sendiri |
| 📦 **Manajemen Inventaris** | Kelola kategori dan item dengan mudah                    |
| 📊 **Tracking Stok**        | Pantau pergerakan stok masuk dan keluar                  |
| 🛒 **Toko Online**          | Halaman publik untuk pelanggan memesan                   |
| 📍 **Lokasi Order**         | Tracking lokasi pelanggan dengan peta                    |
| 📱 **Responsive**           | Dapat diakses dari desktop maupun mobile                 |

---

## 📖 Panduan Pengguna

### 1. Pendaftaran & Login

#### Mendaftar Akun Baru

1. Buka halaman utama aplikasi
2. Klik tombol **"Register"** di pojok kanan atas
3. Isi formulir pendaftaran:
    - **Nama**: Nama lengkap Anda
    - **Email**: Alamat email aktif
    - **Password**: Minimal 8 karakter
    - **Konfirmasi Password**: Ulangi password
4. Klik **"Register"** untuk menyelesaikan pendaftaran

#### Login

1. Klik tombol **"Log in"** di pojok kanan atas
2. Masukkan **Email** dan **Password**
3. Klik **"Log in"**

---

### 2. Membuat Toko

Setelah login, Anda perlu membuat toko terlebih dahulu:

1. Anda akan diarahkan ke halaman **"Buat Toko"**
2. Isi informasi toko:
    - **Nama Toko**: Nama toko yang akan ditampilkan
    - **Slug**: URL unik toko (otomatis atau manual)
    - **Deskripsi**: Deskripsi singkat tentang toko
    - **Alamat**: Lokasi fisik toko
3. Klik **"Buat Toko"**
4. Tunggu persetujuan dari Super Admin

> ⚠️ **Catatan**: Toko Anda akan dalam status **"Pending"** sampai disetujui oleh Super Admin.

---

### 3. Dashboard

Dashboard adalah pusat kontrol toko Anda dengan beberapa tab:

#### Tab Ringkasan

Menampilkan statistik penting:

-   **Total Barang**: Jumlah item di toko
-   **Total Kategori**: Jumlah kategori
-   **Nilai Inventori**: Total nilai stok (harga × kuantitas)
-   **Total Pesanan**: Jumlah order yang diterima
-   **Pendapatan**: Total dari pesanan yang selesai
-   **Stok Menipis**: Item dengan stok ≤ 10
-   **Stok Habis**: Item dengan stok = 0

#### Tab Barang

Daftar semua item dengan fitur:

-   🔍 Pencarian berdasarkan nama/kode
-   🏷️ Filter berdasarkan kategori
-   ➕ Tambah barang baru
-   ✏️ Edit dan hapus barang

#### Tab Kategori

Kelola kategori produk:

-   Lihat daftar kategori
-   Jumlah item per kategori
-   Tambah, edit, hapus kategori

#### Tab Pesanan

Kelola pesanan pelanggan:

-   Lihat daftar pesanan
-   Filter berdasarkan status
-   Update status pesanan
-   Lihat lokasi pesanan di peta

#### Tab Riwayat

History pergerakan stok:

-   Filter berdasarkan tipe (masuk/keluar)
-   Filter berdasarkan item
-   Filter berdasarkan tanggal

---

### 4. Manajemen Kategori

#### Menambah Kategori

1. Buka tab **"Kategori"** di Dashboard
2. Klik tombol **"+ Tambah Kategori"**
3. Isi nama kategori
4. Klik **"Simpan"**

#### Mengedit Kategori

1. Pada daftar kategori, klik tombol **Edit** (ikon pensil)
2. Ubah nama kategori
3. Klik **"Simpan"**

#### Menghapus Kategori

1. Klik tombol **Hapus** (ikon tempat sampah)
2. Konfirmasi penghapusan

> ⚠️ **Catatan**: Kategori yang memiliki item tidak dapat dihapus.

---

### 5. Manajemen Item/Barang

#### Menambah Barang Baru

1. Buka tab **"Barang"** di Dashboard
2. Klik **"+ Tambah Barang"**
3. Isi formulir:
    - **Nama Barang**: Nama produk
    - **Kode**: Kode unik (SKU)
    - **Kategori**: Pilih kategori
    - **Harga**: Harga jual
    - **Kuantitas**: Jumlah stok awal
    - **Gambar**: Upload foto produk (opsional)
    - **Deskripsi**: Deskripsi produk
4. Klik **"Simpan"**

#### Mengedit Barang

1. Klik tombol **Edit** pada item
2. Ubah informasi yang diperlukan
3. Klik **"Simpan"**

#### Menghapus Barang

1. Klik tombol **Hapus**
2. Konfirmasi penghapusan

> 💡 **Tips**: Gunakan fitur pencarian dan filter untuk menemukan barang dengan cepat.

---

### 6. Stock Movement (Stok Masuk/Keluar)

#### Mencatat Stok Masuk

1. Buka tab **"Riwayat"** atau klik **"+ Stok Masuk/Keluar"**
2. Pilih **Tipe: Masuk**
3. Pilih **Item** yang akan ditambah stoknya
4. Masukkan **Jumlah**
5. Tambahkan **Catatan** (opsional)
6. Klik **"Simpan"**

#### Mencatat Stok Keluar

1. Pilih **Tipe: Keluar**
2. Pilih **Item**
3. Masukkan **Jumlah** (tidak boleh melebihi stok tersedia)
4. Tambahkan **Catatan** (opsional)
5. Klik **"Simpan"**

#### Melihat Riwayat Stok

-   Filter berdasarkan **Tipe** (Masuk/Keluar)
-   Filter berdasarkan **Item** tertentu
-   Filter berdasarkan **Rentang Tanggal**

---

### 7. Manajemen Order

#### Melihat Daftar Order

1. Buka tab **"Pesanan"** di Dashboard
2. Lihat daftar pesanan dari pelanggan
3. Gunakan pencarian untuk mencari berdasarkan nama/nomor HP

#### Status Order

| Status           | Deskripsi                         |
| ---------------- | --------------------------------- |
| 🟡 **Pending**   | Pesanan baru, menunggu konfirmasi |
| 🟢 **Accepted**  | Pesanan diterima dan diproses     |
| ✅ **Completed** | Pesanan selesai                   |
| 🔴 **Rejected**  | Pesanan ditolak                   |

#### Mengubah Status Order

1. Klik pesanan untuk melihat detail
2. Pilih status baru dari dropdown
3. Konfirmasi perubahan

---

### 8. Profil Toko

#### Mengedit Profil Toko

1. Klik menu **"Profil Toko"** di sidebar
2. Edit informasi:
    - Nama toko
    - Deskripsi
    - Alamat
    - Banner toko
3. Klik **"Simpan"**

---

## 👑 Panduan Super Admin

Super Admin memiliki akses untuk mengelola semua toko di platform.

### Dashboard Super Admin

-   Lihat statistik keseluruhan platform
-   Daftar semua toko yang terdaftar

### Verifikasi Toko

1. Lihat daftar toko dengan status **Pending**
2. Review informasi toko
3. Klik **"Approve"** untuk menyetujui atau **"Reject"** untuk menolak

---

## 🛒 Toko Online (Frontend)

Pelanggan dapat mengakses toko Anda melalui URL publik.

### Mengunjungi Toko

1. Buka URL toko: `domain.com/{slug-toko}`
2. Lihat daftar produk yang tersedia
3. Klik produk untuk melihat detail

### Melakukan Pemesanan

1. Pilih produk dan tambahkan ke keranjang
2. Buka **Keranjang** untuk review pesanan
3. Isi informasi:
    - Nama pelanggan
    - Nomor HP
    - Alamat/Lokasi
4. Klik **"Checkout"** untuk menyelesaikan pesanan

---

## 🛠️ Teknologi

-   **Backend**: Laravel 10
-   **Frontend**: Blade + Tailwind CSS
-   **Database**: PostgreSQL
-   **Maps**: Leaflet.js

---

## 📞 Kontak

Jika ada pertanyaan atau kendala, hubungi:

-   📧 Email: pantau.barang@proton.me

---

<p align="center">
  <strong>© 2025 Pantau Barang. All rights reserved.</strong>
</p>
