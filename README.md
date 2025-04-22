# 🚗 Rent-a-Car Vehicle Application 🚙

Welcome to the Rent-a-Car Vehicle Application, a Laravel-based web application developed by RedcodeSolution for managing vehicle rentals. This private repository provides a robust platform for users to rent vehicles and administrators to manage bookings, drivers, vehicles, and customers. 🌟

## 📋 Table of Contents
- [🏁 Overview](#overview)
- [✨ Features](#features)
- [🧭 Navigation Menu](#navigation-menu)
- [🛠️ Installation](#installation)
- [🚦 Usage](#usage)
- [🗂️ Project Structure](#project-structure)
- [🤝 Contributing](#contributing)
- [📄 License](#license)

## 🏁 Overview
The rc-rent-vehicle-application is designed to streamline vehicle rental operations. It includes separate interfaces for users (renters) and administrators, with authentication-based routing to ensure secure access to respective dashboards. 🔐

- **📦 Repository**: RedcodeSolution/rc-rent-vehicle-application
- **🌿 Branch**: dev-preview (latest updates pushed recently)
- **🔄 Recent Activity**: Merge pull request #47 from RedcodeSolution/05-update

## ✨ Features

### 👤 User Features
- 🚗 Browse and rent vehicles
- 📋 View booking history
- ℹ️ Access "About Us" and "Contact Us" pages

### 👑 Admin Features
- 🛠️ Manage vehicles, drivers, customers, and bookings
- 📱 Responsive navigation for desktop and mobile views

### 🔐 Authentication
- 🔑 Laravel Breeze for login, registration, and profile management
- 🚪 Role-based routing (admin vs. user dashboards)

### 🎨 Frontend
- 🖌️ Tailwind CSS for styling
- 🌊 Alpine.js for interactive navigation menus

## 🧭 Navigation Menu

### 👤 User Navigation
- **🏠 Dashboard**: `/user/home`
- **🚗 Car Rental**: `/rental`
- **📅 My Bookings**: `/booking`
- **ℹ️ About Us**: `/about`
- **📞 Contact Us**: `/contact`
- **👤 Profile**: Profile settings
- **🚪 Logout**

### 👑 Admin Navigation
- **🏆 Home**: `/admin/dashboard`
- **🚙 Manage Cars**: `/vehicles`
- **👥 Manage Drivers**: `/drivers`
- **👥 Manage Customer**: `/admin/customer`
- **📋 Manage Request**: `/admin/booking`
- **📊 Reports**: (Placeholder - TBD)
- **👤 Profile**: Profile settings
- **🚪 Logout**

Both menus are responsive, with a mobile-friendly dropdown triggered by Alpine.js. 📱

## 🛠️ Installation

### 📋 Prerequisites
- 💻 PHP >= 8.1
- 📦 Composer
- 🟢 Node.js & npm
- 💾 MySQL or another supported database

### 🚀 Steps

1. **📥 Clone the Repository**
   ```bash
   git clone git@github.com:RedcodeSolution/rc-rent-vehicle-application.git
   cd rc-rent-vehicle-application
   ```

2. **📦 Install PHP Dependencies**
   ```bash
   composer install
   ```

3. **🟢 Install Node.js Dependencies**
   ```bash
   npm install
   ```

4. **⚙️ Set Up Environment**
   - Copy `.env.example` to `.env`
   - Update database credentials in `.env`
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=rent_a_car
     DB_USERNAME=root
     DB_PASSWORD=
     ```
5. **🔑 Generate Application Key**
   ```bash
   php artisan key:generate
   ```

6. **💾 Run Migrations**
   ```bash
   php artisan migrate
   ```

7. **🏗️ Build Frontend Assets**
   ```bash
   npm run dev
   ```

8. **🌐 Start the Server**
     ```bash
   php artisan serve
   ```
9. **Vite manifest Error Correct code**
 
   ```bash
   npm install vite laravel-vite-plugin --save-dev

   npm run build

   ```
10.🖼️ Image Storage Configuration & Clearing Cache in Laravel

    
   ```bash
   🚀 Step 1: Remove Public Storage Folder
               rm -rf public/storage

  🛠️ Step 2: Delete the Images Directory Using Tinker
               php artisan tinker
               Storage::disk('public')->deleteDirectory('images'); exit;

  🔄 Step 3: Clear Configuration & Cache
               php artisan config:clear
               php artisan cache:clear

  🔗 Step 4: Create a Storage Symlink
               php artisan storage:link
   ```
11. **🌐 Start the Server**
     ```bash
          php artisan serve
   ```
   Access the app at http://localhost:8000 🚀

## 🚦 Usage
- **🌐 Guest Access**: Visit `/` to see the welcome page
- **👤 User Access**: Log in as a non-admin user to access the user dashboard
- **👑 Admin Access**: Log in as an admin to manage resources via `/admin/dashboard`
- **🧭 Navigation**: Use the top navigation bar (desktop) or hamburger menu (mobile)

## 🗂️ Project Structure
```
rc-rent-vehicle-application/
├── 📂 app/                    # Application logic
├── 🚀 bootstrap/             # Bootstrap files
├── ⚙️ config/                # Configuration files
├── 💾 database/              # Migrations, seeds
├── 🌐 public/                # Public assets
├── 🎨 resources/             # Views, Blade templates
│   ├── 👀 views/
│   │   ├── 👑 admin/        # Admin-specific views
│   │   ├── 🔐 auth/         # Authentication views
│   │   ├── 👤 user/         # User-specific views
│   │   └── 🏠 welcome.blade.php
├── 🧭 routes/                # Route definitions
├── 💽 storage/               # Storage
├── 🧪 tests/                 # Test files
└── ...
```

## 🤝 Contributing
Contributions are welcome! 🎉

1. 🍴 Fork the repository
2. 🌿 Create a feature branch
   ```bash
   git checkout -b feature/your-feature
   ```
3. 💾 Commit your changes
   ```bash
   git commit -m "Add your feature"
   ```
4. 🚀 Push to your branch
   ```bash
   git push origin feature/your-feature
   ```
5. 📬 Open a pull request against the `dev-preview` branch

### 🌟 Recent Contributors
- Chathupachamika: Merge pull request #47 (05-update)

## 📄 License
This project is licensed under the MIT License. 📜

## 📝 Additional Notes
- **🏷️ Latest Commit**: 79d803f - "Merge pull request #47 from RedcodeSolution/05-update"
- **📞 Contact**: Use the GitHub Issues tab for any issues or suggestions 🆘

Feel free to customize this README further based on your specific project needs! 🚀🌈

## 🏢 About RedcodeSolution 🌐

### 🚀 Our Mission
RedcodeSolution is a passionate software development team dedicated to creating innovative and efficient technological solutions. We specialize in developing web applications that solve real-world problems with cutting-edge technology and user-centric design.

### 💡 Our Expertise
- 🖥️ Web Application Development
- 🌐 Full-Stack Solutions
- 🛠️ Custom Software Engineering
- 🔐 Secure Authentication Systems
- 📱 Responsive Design

### 🤝 Our Values
- **Innovation**: Pushing the boundaries of technology
- **Quality**: Delivering high-performance, reliable solutions
- **Collaboration**: Working closely with clients and team members
- **User Experience**: Prioritizing intuitive and seamless interfaces

### 🌟 Contact Us
- **Website**: [www.redcodesolution.com](https://www.redcodesolution.com)
- **Email**: contact@redcodesolution.com
- **GitHub**: [RedcodeSolution](https://github.com/RedcodeSolution)

### 🏆 Why Choose RedcodeSolution?
- Custom-tailored software solutions
- Agile and adaptive development approach
- Cutting-edge technology stack
- Commitment to client success
- Continuous support and maintenance

---

**Made with ❤️ by RedcodeSolution** 🚀🌈
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
