# API Documentation - Vinsa.me E-Commerce

## Base URL
```
http://localhost:8000/api
```

## Authentication
Semua endpoint memerlukan autentikasi menggunakan **Sanctum Token**.

Header yang diperlukan:
```
Authorization: Bearer YOUR_API_TOKEN
Content-Type: application/json
```
---

## 🔐 Authentication Endpoints - Manajemen User & Sesi

### 1. Registrasi Akun
**POST** `/register`

**Request Body:**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "address": "Jl. Raya No. 123, Jakarta",
  "phone": "08123456789",
  "role": "customer"
}
```

**Validation:**
- `name`: required, string, max 255
- `email`: required, string, email, max 255, unique in `users`
- `password`: required, string, min 8
- `address`: nullable, string
- `phone`: nullable, string
- `role`: nullable, string, in: `admin`, `customer`, `officer` (default: `customer`)

**Response:** `201 Created`
```json
{
  "message": "User registered successfully",
  "user": {
    "name": "John Doe",
    "email": "john@example.com",
    "address": "Jl. Raya No. 123, Jakarta",
    "phone": "08123456789",
    "role": "customer",
    "updated_at": "2026-05-06T00:00:00.000000Z",
    "created_at": "2026-05-06T00:00:00.000000Z",
    "id": 1
  },
  "access_token": "1|xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx",
  "token_type": "Bearer"
}
```

### 2. Login
**POST** `/login`

**Request Body:**
```json
{
  "email": "john@example.com",
  "password": "password123"
}
```

**Response:** `200 OK`
```json
{
  "message": "Login successful",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "address": "Jl. Raya No. 123, Jakarta",
    "phone": "08123456789",
    "role": "customer",
    "email_verified_at": null,
    "created_at": "2026-05-06T00:00:00.000000Z",
    "updated_at": "2026-05-06T00:00:00.000000Z"
  },
  "access_token": "2|xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx",
  "token_type": "Bearer"
}
```

### 3. Profil User Saat Ini
**GET** `/profile`

**Headers:**
```
Authorization: Bearer YOUR_API_TOKEN
```

**Response:** `200 OK`
```json
{
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "address": "Jl. Raya No. 123, Jakarta",
    "phone": "08123456789",
    "role": "customer",
    "email_verified_at": null,
    "created_at": "2026-05-06T00:00:00.000000Z",
    "updated_at": "2026-05-06T00:00:00.000000Z"
  }
}
```

### 4. Logout
**POST** `/logout`

**Headers:**
```
Authorization: Bearer YOUR_API_TOKEN
```

**Response:** `200 OK`
```json
{
  "message": "Successfully logged out"
}
```

---

## 📦 Brands - Manajemen Brand

### 1. Daftar Semua Brand
**GET** `/brands`

**Response:**
```json
[
  {
    "id": 1,
    "brand_name": "Nike",
    "description": "Brand olahraga terkemuka"
  },
  {
    "id": 2,
    "brand_name": "Adidas",
    "description": "Brand sportswear internasional"
  }
]
```

### 2. Buat Brand Baru
**POST** `/brands`

**Request Body:**
```json
{
  "brand_name": "Nike",
  "description": "Brand olahraga terkemuka"
}
```

**Response:** `201 Created`
```json
{
  "id": 1,
  "brand_name": "Nike",
  "description": "Brand olahraga terkemuka"
}
```

### 3. Detail Brand
**GET** `/brands/{id}`

**Response:**
```json
{
  "id": 1,
  "brand_name": "Nike",
  "description": "Brand olahraga terkemuka",
  "products": [
    {
      "id": 1,
      "product_name": "Nike Air Max",
      "price": 1500000
    }
  ]
}
```

### 4. Update Brand
**PUT** `/brands/{id}`

**Request Body:**
```json
{
  "brand_name": "Nike Updated",
  "description": "Updated description"
}
```

**Response:** `200 OK`

### 5. Hapus Brand
**DELETE** `/brands/{id}`

**Response:** `200 OK`
```json
{
  "message": "Brand deleted successfully"
}
```

---

## 🏷️ Categories - Manajemen Kategori

### 1. Daftar Semua Kategori
**GET** `/categories`

**Response:**
```json
[
  {
    "id": 1,
    "category_name": "Electronics",
    "description": "Elektronik dan gadget",
    "products": []
  }
]
```

### 2. Buat Kategori
**POST** `/categories`

**Request Body:**
```json
{
  "category_name": "Electronics",
  "description": "Elektronik dan gadget"
}
```

**Response:** `201 Created`

### 3. Detail Kategori
**GET** `/categories/{id}`

**Response:**
```json
{
  "id": 1,
  "category_name": "Electronics",
  "description": "Elektronik dan gadget",
  "products": [
    {
      "id": 1,
      "product_name": "iPhone 15",
      "price": 12000000
    }
  ]
}
```

### 4. Produk dalam Kategori
**GET** `/categories/{id}/products`

**Response:**
```json
[
  {
    "id": 1,
    "product_name": "iPhone 15",
    "price": 12000000,
    "stock_quantity": 50
  }
]
```

### 5. Update Kategori
**PUT** `/categories/{id}`

**Request Body:**
```json
{
  "category_name": "Updated Category",
  "description": "Updated description"
}
```

### 6. Hapus Kategori
**DELETE** `/categories/{id}`

---

## 🛍️ Products - Manajemen Produk

### 1. Daftar Semua Produk
**GET** `/products`

**Response:**
```json
[
  {
    "id": 1,
    "product_name": "iPhone 15",
    "description": "Smartphone flagship Apple",
    "price": 12000000,
    "stock_quantity": 50,
    "image_url": "https://example.com/iphone15.jpg",
    "category_id": 1,
    "brand_id": 1,
    "category": {
      "id": 1,
      "category_name": "Electronics"
    },
    "brand": {
      "id": 1,
      "brand_name": "Apple"
    }
  }
]
```

### 2. Buat Produk
**POST** `/products`

**Request Body:**
```json
{
  "product_name": "iPhone 15",
  "description": "Smartphone flagship Apple",
  "price": 12000000,
  "category_id": 1,
  "brand_id": 1,
  "image_url": "https://example.com/iphone15.jpg",
  "stock_quantity": 50
}
```

**Validation:**
- `product_name`: required, string, max 255
- `description`: required, string
- `price`: required, numeric, min 0
- `category_id`: required, exists in categories
- `brand_id`: required, exists in brands
- `image_url`: required, string
- `stock_quantity`: required, integer, min 0

### 3. Detail Produk
**GET** `/products/{id}`

**Response:**
```json
{
  "id": 1,
  "product_name": "iPhone 15",
  "description": "Smartphone flagship Apple",
  "price": 12000000,
  "stock_quantity": 50,
  "image_url": "https://example.com/iphone15.jpg",
  "category": { ... },
  "brand": { ... }
}
```

### 4. Update Produk
**PUT** `/products/{id}`

**Request Body:**
```json
{
  "product_name": "iPhone 15 Pro",
  "price": 13000000,
  "stock_quantity": 45
}
```

### 5. Produk per Brand
**GET** `/products/brand/{brandId}`

**Response:**
```json
[
  {
    "id": 1,
    "product_name": "iPhone 15",
    "price": 12000000
  },
  {
    "id": 2,
    "product_name": "iPhone 15 Pro",
    "price": 13000000
  }
]
```

### 6. Hapus Produk
**DELETE** `/products/{id}`

---

## 📋 Orders - Manajemen Order

### 1. Daftar Semua Order
**GET** `/orders`

**Response:**
```json
[
  {
    "id": 1,
    "user_id": 1,
    "order_date": "2024-01-15 10:30:00",
    "status": "pending",
    "total_amount": 24000000,
    "shipping_address": "Jl. Merdeka 123, Jakarta",
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com"
    },
    "items": [
      {
        "id": 1,
        "product_id": 1,
        "quantity": 2
      }
    ]
  }
]
```

### 2. Buat Order
**POST** `/orders`

**Request Body:**
```json
{
  "user_id": 1,
  "order_date": "2024-01-15",
  "status": "pending",
  "total_amount": 24000000,
  "shipping_address": "Jl. Merdeka 123, Jakarta"
}
```

**Status Options:** `pending`, `paid`, `shipped`, `delivered`, `cancelled`

### 3. Detail Order
**GET** `/orders/{id}`

**Response:**
```json
{
  "id": 1,
  "user_id": 1,
  "order_date": "2024-01-15 10:30:00",
  "status": "pending",
  "total_amount": 24000000,
  "shipping_address": "Jl. Merdeka 123, Jakarta",
  "user": { ... },
  "items": [
    {
      "id": 1,
      "order_id": 1,
      "product_id": 1,
      "quantity": 2,
      "product": {
        "id": 1,
        "product_name": "iPhone 15",
        "price": 12000000
      }
    }
  ]
}
```

### 4. Update Order Status
**PUT** `/orders/{id}`

**Request Body:**
```json
{
  "status": "paid"
}
```

### 5. Item dalam Order
**GET** `/orders/{id}/items`

**Response:**
```json
[
  {
    "id": 1,
    "order_id": 1,
    "product_id": 1,
    "quantity": 2,
    "product": {
      "id": 1,
      "product_name": "iPhone 15",
      "price": 12000000
    }
  }
]
```

### 6. Order per User
**GET** `/users/{userId}/orders`

**Response:**
```json
[
  {
    "id": 1,
    "user_id": 1,
    "order_date": "2024-01-15 10:30:00",
    "status": "pending",
    "total_amount": 24000000,
    "items": [...]
  }
]
```

### 7. Hapus Order
**DELETE** `/orders/{id}`

---

## 🛒 Order Items - Item dalam Order

### 1. Daftar Semua Order Items
**GET** `/order-items`

**Response:**
```json
[
  {
    "id": 1,
    "order_id": 1,
    "product_id": 1,
    "quantity": 2,
    "order": { ... },
    "product": { ... }
  }
]
```

### 2. Tambah Item ke Order
**POST** `/order-items`

**Request Body:**
```json
{
  "order_id": 1,
  "product_id": 1,
  "quantity": 2
}
```

### 3. Detail Order Item
**GET** `/order-items/{id}`

### 4. Update Quantity
**PUT** `/order-items/{id}`

**Request Body:**
```json
{
  "quantity": 3
}
```

### 5. Hapus Item dari Order
**DELETE** `/order-items/{id}`

---

## 💳 Payments - Manajemen Pembayaran

### 1. Daftar Semua Pembayaran
**GET** `/payments`

**Response:**
```json
[
  {
    "id": 1,
    "payment_method_id": 1,
    "payment_date": "2024-01-15 11:00:00",
    "amount": 24000000,
    "status": "success",
    "paymentMethod": {
      "id": 1,
      "method_name": "Credit Card"
    }
  }
]
```

### 2. Buat Pembayaran
**POST** `/payments`

**Request Body:**
```json
{
  "payment_method_id": 1,
  "payment_date": "2024-01-15",
  "amount": 24000000,
  "status": "pending"
}
```

**Status Options:** `pending`, `success`, `failed`, `refunded`

### 3. Detail Pembayaran
**GET** `/payments/{id}`

### 4. Update Status Pembayaran
**PUT** `/payments/{id}`

**Request Body:**
```json
{
  "status": "success"
}
```

### 5. Hapus Pembayaran
**DELETE** `/payments/{id}`

---

## 💰 Payment Methods - Metode Pembayaran

### 1. Daftar Metode Pembayaran
**GET** `/payment-methods`

**Response:**
```json
[
  {
    "id": 1,
    "method_name": "Credit Card"
  },
  {
    "id": 2,
    "method_name": "Bank Transfer"
  }
]
```

### 2. Tambah Metode Pembayaran
**POST** `/payment-methods`

**Request Body:**
```json
{
  "method_name": "E-Wallet"
}
```

### 3. Detail Metode
**GET** `/payment-methods/{id}`

### 4. Update Metode
**PUT** `/payment-methods/{id}`

**Request Body:**
```json
{
  "method_name": "Updated Method"
}
```

### 5. Hapus Metode
**DELETE** `/payment-methods/{id}`

---

## 🛍️ Carts - Keranjang Belanja

### 1. Daftar Semua Keranjang
**GET** `/carts`

**Response:**
```json
[
  {
    "id": 1,
    "user_id": 1,
    "product_id": 1,
    "quantity": 2,
    "user": {
      "id": 1,
      "name": "John Doe"
    },
    "product": {
      "id": 1,
      "product_name": "iPhone 15",
      "price": 12000000
    }
  }
]
```

### 2. Tambah Item ke Keranjang
**POST** `/carts`

**Request Body:**
```json
{
  "user_id": 1,
  "product_id": 1,
  "quantity": 2
}
```

### 3. Detail Keranjang
**GET** `/carts/{id}`

### 4. Update Quantity Keranjang
**PUT** `/carts/{id}`

**Request Body:**
```json
{
  "quantity": 3
}
```

### 5. Hapus dari Keranjang
**DELETE** `/carts/{id}`

---

## 🚚 Shipments - Pengiriman

### 1. Daftar Semua Pengiriman
**GET** `/shipments`

**Response:**
```json
[
  {
    "id": 1,
    "order_id": 1,
    "tracking_number": "JNE123456789",
    "courier": "JNE",
    "shipped_date": "2024-01-16",
    "order": {
      "id": 1,
      "total_amount": 24000000
    }
  }
]
```

### 2. Buat Pengiriman
**POST** `/shipments`

**Request Body:**
```json
{
  "order_id": 1,
  "tracking_number": "JNE123456789",
  "courier": "JNE",
  "shipped_date": "2024-01-16"
}
```

**Validation:**
- `order_id`: required, exists in orders
- `tracking_number`: required, string, unique
- `courier`: required, string
- `shipped_date`: required, date

### 3. Detail Pengiriman
**GET** `/shipments/{id}`

### 4. Update Pengiriman
**PUT** `/shipments/{id}`

**Request Body:**
```json
{
  "courier": "JNE Updated",
  "shipped_date": "2024-01-17"
}
```

### 5. Hapus Pengiriman
**DELETE** `/shipments/{id}`

---

## Error Handling

### Validation Error
**Status Code:** `422 Unprocessable Entity`

**Response:**
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "product_name": [
      "The product name field is required."
    ],
    "price": [
      "The price must be a number."
    ]
  }
}
```

### Not Found Error
**Status Code:** `404 Not Found`

**Response:**
```json
{
  "message": "Not Found"
}
```

### Unauthorized Error
**Status Code:** `401 Unauthorized`

**Response:**
```json
{
  "message": "Unauthorized"
}
```

---

## Contoh Request dengan cURL

### Get All Brands
```bash
curl -X GET "http://localhost:8000/api/brands" \
  -H "Authorization: Bearer YOUR_API_TOKEN" \
  -H "Content-Type: application/json"
```

### Create Brand
```bash
curl -X POST "http://localhost:8000/api/brands" \
  -H "Authorization: Bearer YOUR_API_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "brand_name": "Nike",
    "description": "Brand olahraga terkemuka"
  }'
```

### Update Product
```bash
curl -X PUT "http://localhost:8000/api/products/1" \
  -H "Authorization: Bearer YOUR_API_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "product_name": "iPhone 15 Pro",
    "price": 13000000
  }'
```

### Delete Order
```bash
curl -X DELETE "http://localhost:8000/api/orders/1" \
  -H "Authorization: Bearer YOUR_API_TOKEN" \
  -H "Content-Type: application/json"
```

---

## Response Headers

```
Content-Type: application/json
Cache-Control: no-cache, private
```

---

## API Response Format

Semua response mengikuti format standar JSON:

**Success Response (2xx):**
```json
{
  "data": {
    "id": 1,
    "name": "Example"
  }
}
```

**Error Response (4xx/5xx):**
```json
{
  "message": "Error message",
  "errors": {}
}
```

---

## Rate Limiting

Currently no rate limiting applied. Dapat ditambahkan sesuai kebutuhan di middleware.

---

## Versioning

API Version: **v1**
- URL prefix tidak menggunakan versioning, tapi dapat ditambahkan di masa depan

---

## Last Updated
January 15, 2024

**Created by:** API Documentation
**For:** Vinsa.me E-Commerce Platform
