@echo off
setlocal
cd /d %~dp0
echo [1/5] Installing Laravel 9 dependencies for PHP 8.0...
call composer install
if errorlevel 1 goto :error
if not exist .env copy .env.example .env
if not exist database\database.sqlite type nul > database\database.sqlite
echo [2/5] Generating application key...
C:\xampp\php\php.exe artisan key:generate
if errorlevel 1 goto :error
echo [3/5] Running migrations and demo seed data...
C:\xampp\php\php.exe artisan migrate:fresh --seed
if errorlevel 1 goto :error
echo [4/5] Clearing caches...
C:\xampp\php\php.exe artisan optimize:clear
if errorlevel 1 goto :error
echo [5/5] Starting server...
echo Open http://127.0.0.1:8000
C:\xampp\php\php.exe artisan serve
exit /b 0
:error
echo Setup failed. Copy the last error and send it for diagnosis.
pause
exit /b 1
