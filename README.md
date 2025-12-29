# 🏫 TK Bina Pertiwi
> **Modern Kindergarten Management System**  
> _Built with passion, powered by Laravel & Filament._

[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![Filament](https://img.shields.io/badge/Filament-F28D15?style=for-the-badge&logo=laravel&logoColor=white)](https://filamentphp.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net)

---

## ✨ Overview

**TK Bina Pertiwi** represents a leap forward in school management systems. Designed with a premium aesthetic and a "fun" atmosphere suitable for a kindergarten, this application streamlines administrative tasks while providing a delightful experience for teachers and parents.

### 🚀 Key Features

-   **🎨 Premium Landing Page**: A vibrant, responsive, and animated front-facing website.
-   **👨‍🏫 Teacher Dashboard**: Manage classes, student data, and generate development reports effortlessly.
-   **👪 Parent Portal**: Secure access for parents to view their child's progress and gallery.
-   **📊 Smart Reporting**: Automated student development scoring using **Fuzzy Logic**.
-   **🖼️ Dynamic Gallery**: A CMS-managed gallery to showcase school activities.
-   **🔐 Role-Based Access**: Secure environments for Admins, Teachers, and Parents.

---

## 🛠️ Installation Guide

Follow these steps to get the project running on your local machine.

### Prerequisites

Ensure you have the following installed:
-   **PHP** (v8.2 or higher)
-   **Composer**
-   **Node.js** & **NPM**
-   **Git**

### 1️⃣ Clone the Repository

```bash
git clone https://github.com/Start-Syarif/tk_binapertiwi.git
cd tk_binapertiwi
```

### 2️⃣ Install Dependencies

Install PHP and JavaScript packages:

```bash
composer install
npm install
```

### 3️⃣ Environment Setup

Create your environment configuration file:

```bash
cp .env.example .env
```

Generate the application encryption key:

```bash
php artisan key:generate
```

### 4️⃣ Database Setup

This project uses **SQLite** by default for simplicity.

1.  Create the database file (if it wasn't created automatically):
    ```bash
    touch database/database.sqlite
    ```
    *(On Windows, you can just manually create an empty file named `database.sqlite` inside the `database` folder if the command fails, or trust the artisan migrate command to handle it if configured).*

2.  Run migrations and seed the database with sample data:
    ```bash
    php artisan migrate --seed
    ```

### 5️⃣ Build Assets

Compile the frontend assets (Tailwind CSS, JS):

```bash
npm run build
```

---

## 🏁 Running the Application

Start the local development server:

```bash
php artisan serve
```

Access the application at: `http://localhost:8000`

### 🔑 Default Login Credentials

The seeding process creates a demo user for you to access the admin panel immediately.

-   **URL**: `http://localhost:8000/admin`
-   **Email**: `test@example.com`
-   **Password**: `password`

> **Note**: For additional users or role testing, please refer to the `database/seeders/DatabaseSeeder.php` file or create users via the admin panel.

---

## 🤝 Contributing

We welcome contributions! Please feel free to verify functionality, submit Pull Requests, or report issues to help us make TK Bina Pertiwi even better.

---

<p align="center">
  Made with ❤️ for <strong>Bina Pertiwi</strong>
</p>
