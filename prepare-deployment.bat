@echo off
echo ========================================
echo   PERSIAPAN DEPLOYMENT KE HOSTING
echo   Web KKN Peta Desa Gunungsari
echo ========================================
echo.

echo [1/5] Build production assets...
call npm run build

echo [2/5] Clear cache...
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo [3/5] Optimize for production...
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo [4/5] Create deployment folder...
if not exist "deployment" mkdir deployment

echo [5/5] Copy files for upload...
xcopy /E /I /Y "app" "deployment\app"
xcopy /E /I /Y "bootstrap" "deployment\bootstrap"
xcopy /E /I /Y "config" "deployment\config"
xcopy /E /I /Y "database" "deployment\database"
xcopy /E /I /Y "public" "deployment\public"
xcopy /E /I /Y "resources" "deployment\resources"
xcopy /E /I /Y "routes" "deployment\routes"
xcopy /E /I /Y "storage" "deployment\storage"
xcopy /E /I /Y "vendor" "deployment\vendor"
copy ".env.example" "deployment\.env"
copy "artisan" "deployment\artisan"
copy "composer.json" "deployment\composer.json"
copy "composer.lock" "deployment\composer.lock"

echo.
echo ========================================
echo   DEPLOYMENT READY!
echo ========================================
echo.
echo File siap upload ada di folder: deployment\
echo.
echo LANGKAH SELANJUTNYA:
echo 1. Upload semua file di folder 'deployment' ke hosting
echo 2. Edit file .env di hosting (database, APP_URL)
echo 3. Jalankan: php artisan migrate
echo 4. Jalankan: php artisan db:seed --class=AdminSeeder
echo 5. Set permission folder storage: 755
echo.
pause