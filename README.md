# Technical Test CBI

Repo ini berisi Source code untuk Technical Test CBI Nomor 1.

## What App is this?
App ini merupakan aplikasi manajemen inventori/barang sederhana.
|Fungsi                |Deskripsi                          |
|----------------|-------------------------------|
|Create item baru|Menambah item baru pada tabel barang dan kategori|
|Read to do list|View semua item pada tabel barang dan kategori|
|Update item|Mengubah item pada tabel barang dan kategori|
|Delete item|Menghapus item pada tabel barang dan kategori|

## Prerequisite
- PHP
- SQL Server (Locally or Hosted)

## How to Run

1. Add ``` .env ``` file in the project's root folder
```
# Add the Database Credentials
database.default.hostname = 
database.default.database = 
database.default.username = 
database.default.password = 
database.default.DBDriver = SQLSRV
database.default.port = 1433
```
2. Run ``` php spark serve ```