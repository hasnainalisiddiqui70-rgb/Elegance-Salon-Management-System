# Elegance Salon Management System — Laravel 9 / PHP 8.0

This build is specifically converted for **PHP 8.0.30** and uses **Laravel 9.52+**. It keeps the same salon-management features while avoiding the PHP 8.3 requirement of Laravel 13.

## Requirements
- Windows + XAMPP PHP 8.0.30 (or any PHP >= 8.0.2 and < 9)
- Composer 2.x
- PHP extensions: openssl, mbstring, fileinfo, pdo_sqlite/sqlite3 (default) or pdo_mysql

## Recommended local setup (SQLite — no MySQL required)
Open PowerShell in this exact project folder and run one command at a time:

```powershell
composer install
copy .env.example .env
if (!(Test-Path database\database.sqlite)) { New-Item database\database.sqlite -ItemType File }
C:\xampp\php\php.exe artisan key:generate
C:\xampp\php\php.exe artisan migrate:fresh --seed
C:\xampp\php\php.exe artisan serve
```

Open: http://127.0.0.1:8000

### Demo accounts
- Admin: `admin@elegance.local` / `Admin@123`
- Receptionist: `reception@elegance.local` / `Reception@123`
- Stylist: `stylist@elegance.local` / `Stylist@123`

## MySQL (optional)
Set `.env` to:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=elegance_salon
DB_USERNAME=root
DB_PASSWORD=
```
Then create the database and run `C:\xampp\php\php.exe artisan migrate:fresh --seed`.

## Main modules
Authentication and role access, admin/receptionist/stylist dashboards, clients, services, staff, schedules, appointment conflict prevention, calendar, inventory, suppliers, stock movements, low-stock status, payments, invoices, reports/CSV, notifications, feedback, settings and responsive UI.
