# Woliba - Wellness Onboarding Platform

Woliba is a lightweight, passwordless onboarding system built with Laravel. It's designed to help organizations streamline the process of inviting employees to register and explore their personal wellness interests and well-being pillars, removing the friction of traditional password-based logins.

This project was developed with a focus on clean architecture, efficient workflows, and robust security using an OTP-based authentication system.

## 🚀 Key Features

- **Admin-Driven Invitations**  
  Admins can easily generate and send secure, and token based links to employees.

- **Passwordless Login**  
  Employees access the platform directly via their unique invite link, eliminating the need to create and remember a password.

- **OTP Verification Flow**  
  A multi-step security process requires users to verify their identity with a One-Time Password (OTP) sent via email before they can proceed with registration.

- **Wellness Interest Capture**  
  The onboarding process is simple and intuitive, allowing users to select and save their wellness preferences and well-being pillars.

- **Secure Registration**  
  After successful OTP verification, users complete their profile, and their information is securely registered in the system.

## 🛠️ Tech Stack

- **Framework**: Laravel 11
- **Authentication**: Custom OTP-based solution
- **Database**: MySQL
- **Frontend**: Blade templates
- **Notifications**: Laravel Notifications (Email)

## 📦 Installation & Setup

Clone the repository from:
```bash
git clone https://github.com/tejas9033/woliba.git
```

Navigate to the project directory:
```bash
cd woliba
```

Install PHP dependencies:
```bash
composer install
```

Configure environment:
```bash
cp .env.example .env
```

Open the newly created .env file and update your database credentials and other settings as needed.

Generate an application key:
```bash
php artisan key:generate
```

Run database migrations and seeders:
```bash
php artisan migrate:fresh --seed
```

## 📦 API Testing Information

### Postman Collection
- A complete **Postman collection** is provided in the `postman/` folder. This allows you to easily test all API endpoints and understand the expected request/response formats.

### Automated Tests
- To ensure the backend is working as expected, you can run the automated test suite with the following command:

```bash
php artisan test
```

## 🤝 Feedback & Contributions:

Your feedback is highly valuable. If you have any questions, suggestions for improvements, or would like to report an issue, please feel free to open a new issue on the GitHub repository.

Thank you for your time and consideration.