@echo off
echo ========================================
echo   MENJALANKAN PERBAIKAN KEAMANAN
echo ========================================
echo.

echo [1/3] Menjalankan migrations...
php artisan migrate --force
if %errorlevel% neq 0 (
    echo ERROR: Migration gagal!
    pause
    exit /b 1
)
echo ✓ Migrations berhasil
echo.

echo [2/3] Membuat backup database...
php artisan db:backup
if %errorlevel% neq 0 (
    echo WARNING: Backup gagal, tapi lanjut...
)
echo ✓ Backup selesai
echo.

echo [3/3] Clearing cache...
php artisan config:clear
php artisan cache:clear
php artisan view:clear
echo ✓ Cache cleared
echo.

echo ========================================
echo   PERBAIKAN SELESAI!
echo ========================================
echo.
echo PENTING - Lakukan hal berikut:
echo 1. Login dan GANTI PASSWORD admin
echo 2. Set APP_DEBUG=false di .env untuk production
echo 3. Setup backup otomatis (cron/task scheduler)
echo 4. Review file SECURITY_FIXES.md
echo.
echo Login: admin@gunungsari.id
echo Pass:  Gunungsari@2025!Secure
echo.
pause
