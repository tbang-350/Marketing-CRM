# Icewall v3.0.2 - Laravel Admin Dashboard

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Icewall

Icewall is a modern Laravel-based admin dashboard template built with Laravel 10.x and Tailwind CSS. It provides a comprehensive set of features and components for building powerful web applications.

## Features

- 🎨 Modern UI with Tailwind CSS
- 📱 Responsive Design
- 🔄 Real-time Updates
- 📊 Advanced Data Visualization with Chart.js
- 📅 Full Calendar Integration
- 📝 Rich Text Editor (CKEditor 5)
- 🗺️ Interactive Maps with Leaflet
- 📊 Data Tables with Tabulator
- 🎯 Form Validation with PristineJS
- 📤 File Upload with Dropzone
- 🔍 Advanced Search and Filtering
- 🎯 Tooltips with Tippy.js
- 📱 Mobile-friendly Components

## Requirements

- PHP >= 8.1
- Node.js >= 16.x
- Composer
- MySQL/PostgreSQL

## Installation

1. Clone the repository:
```bash
git clone [repository-url]
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install Node.js dependencies:
```bash
npm install
```

4. Create environment file:
```bash
cp .env.example .env
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Configure your database in `.env` file

7. Run migrations:
```bash
php artisan migrate
```

8. Start the development server:
```bash
# Terminal 1 - Laravel server
php artisan serve

# Terminal 2 - Vite development server
npm run dev
```

## Development

- Frontend assets are compiled using Vite
- Tailwind CSS is used for styling
- CKEditor 5 is integrated for rich text editing
- FullCalendar is available for calendar functionality
- Chart.js is included for data visualization

## Building for Production

```bash
npm run build
```

## Security

If you discover any security vulnerabilities, please send an e-mail to the maintainers. All security vulnerabilities will be promptly addressed.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
