# Laravel E-Commerce

A Laravel 12 e-commerce web application with a customer storefront and an admin area.

## Features

### Customer
- User registration, login and logout
- Product catalogue with categories
- Product search and category filtering
- Product details with images, related products and reviews
- Session-based shopping cart
- Checkout and order creation
- Customer order history

### Administration
- Admin-only dashboard and management area
- Category management
- Product management with multiple images
- Stock management
- Order listing and order status management

## Tech Stack

- **PHP 8.2+**
- **Laravel 12**
- **Blade**
- **MySQL / MariaDB**
- **Eloquent ORM**
- **Vite**
- **Tailwind CSS**
- **Axios**

## Architecture

The application follows Laravel's MVC structure:

```text
app/
├── Http/
│   ├── Controllers/
│   │   └── Admin/
│   └── Middleware/
├── Models/
database/
├── migrations/
routes/
└── web.php
resources/
└── views/
```

The data model separates products, categories, product images, carts, orders, order items, reviews and wishlists through Eloquent relationships.

## Installation

### Requirements

- PHP 8.2+
- Composer
- Node.js and npm
- MySQL or MariaDB

### Setup

```bash
git clone https://github.com/Joseph-Nostra/laravel.E-co.git
cd laravel.E-co

composer install
copy .env.example .env
php artisan key:generate
```

Configure your database in `.env`, then run:

```bash
php artisan migrate
npm install
```

### Development

Run the Laravel and Vite development servers:

```bash
php artisan serve
npm run dev
```

The application will be available at the local Laravel URL shown by `php artisan serve`.

## Security Notes

- Authentication uses Laravel's session-based authentication.
- Administrative routes are protected by both authentication and an admin-role middleware.
- Product uploads are validated by file type and size.
- Checkout recalculates prices from the database, validates stock and updates inventory inside a database transaction.

## Author

**Youssef ZHAR — Joseph-Nostra**

GitHub: https://github.com/Joseph-Nostra
