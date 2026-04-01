# Book API

RESTful API untuk manajemen data buku, dibangun dengan [Laravel](https://laravel.com) 12.

## Persyaratan

- PHP >= 8.2
- Composer
- SQLite (default) atau database lain yang didukung Laravel

## Instalasi

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
```

## Menjalankan Server

```bash
php artisan serve
```

Server akan berjalan di `http://localhost:8000`.

## Endpoint API

Base URL: `/api`

### Daftar Semua Buku

```
GET /api/books
```

**Response:**
```json
{
    "success": true,
    "message": "Daftar semua buku",
    "data": [
        {
            "id": 1,
            "title": "Laravel Up & Running",
            "author": "Matt Stauffer",
            "publisher": "O'Reilly Media",
            "year": 2023,
            "created_at": "2026-01-01T00:00:00.000000Z",
            "updated_at": "2026-01-01T00:00:00.000000Z"
        }
    ]
}
```

### Tambah Buku

```
POST /api/books
Content-Type: application/json
```

**Request Body:**
```json
{
    "title": "Laravel Up & Running",
    "author": "Matt Stauffer",
    "publisher": "O'Reilly Media",
    "year": 2023
}
```

**Validasi:**

| Field     | Aturan                              |
|-----------|-------------------------------------|
| title     | required, string, maks 255 karakter |
| author    | required, string, maks 255 karakter |
| publisher | required, string, maks 255 karakter |
| year      | required, integer, antara 1000–9999 |

**Response (201):**
```json
{
    "success": true,
    "message": "Buku berhasil ditambahkan",
    "data": {
        "id": 1,
        "title": "Laravel Up & Running",
        "author": "Matt Stauffer",
        "publisher": "O'Reilly Media",
        "year": 2023,
        "created_at": "2026-01-01T00:00:00.000000Z",
        "updated_at": "2026-01-01T00:00:00.000000Z"
    }
}
```

### Detail Buku

```
GET /api/books/{id}
```

**Response:**
```json
{
    "success": true,
    "message": "Detail buku",
    "data": {
        "id": 1,
        "title": "Laravel Up & Running",
        "author": "Matt Stauffer",
        "publisher": "O'Reilly Media",
        "year": 2023,
        "created_at": "2026-01-01T00:00:00.000000Z",
        "updated_at": "2026-01-01T00:00:00.000000Z"
    }
}
```

### Update Buku

```
PUT /api/books/{id}
Content-Type: application/json
```

**Request Body** (semua field bersifat opsional):
```json
{
    "title": "Laravel: Up & Running, 3rd Edition",
    "year": 2024
}
```

**Response:**
```json
{
    "success": true,
    "message": "Buku berhasil diupdate",
    "data": {
        "id": 1,
        "title": "Laravel: Up & Running, 3rd Edition",
        "author": "Matt Stauffer",
        "publisher": "O'Reilly Media",
        "year": 2024,
        "created_at": "2026-01-01T00:00:00.000000Z",
        "updated_at": "2026-01-01T00:00:00.000000Z"
    }
}
```

### Hapus Buku

```
DELETE /api/books/{id}
```

**Response:**
```json
{
    "success": true,
    "message": "Buku berhasil dihapus"
}
```

## Menjalankan Tests

```bash
php artisan test
```

## Lisensi

Project ini menggunakan lisensi [MIT](https://opensource.org/licenses/MIT).
