# 📚 Educational Center Management System

A scalable and modular **Single Page Application (SPA)** for managing educational institutions, including Quranic centers, academic programs, and training institutes.

## 🔧 Built With

- **Laravel** – Backend framework  
- **Livewire** – Reactive components for Laravel  
- **Blade** – Templating engine  
- **MySQL** – Database  
- **Tailwind CSS** – Styling  
- **Alpine.js** – Lightweight interactivity

## ✨ Features

- Student registration & management  
- Class scheduling & teacher assignment  
- Attendance tracking  
- Progress monitoring  
- Multi-level class support  
- Dynamic dashboards  
- Arabic language support (RTL-ready)  
- Role-based access (Admin, Teacher, Student)

## 🚀 Installation

```bash
git clone git remote add origin https://github.com/MohamedSalahia/LMS.git
cd LMS
composer install
cp .env.example .env
php artisan key:generate
# Set your DB credentials in .env
php artisan migrate --seed
php artisan serve
```

## Demo Access

You can explore the demo version of the project by clicking the link below:

[View Demo](https://lms.webseity.com/login)

### Login Credentials:
- **Email**: admin@webseity.com
- **Password**: demo1234
