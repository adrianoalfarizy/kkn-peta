@echo off
echo ========================================
echo   BACKUP DATABASE PETA RUMAH WARGA
echo   Desa Gunungsari - Dawarblandong
echo ========================================
echo.

set BACKUP_DIR=backup
set DB_FILE=database\database.sqlite
set DATE=%date:~-4%%date:~3,2%%date:~0,2%
set TIME=%time:~0,2%%time:~3,2%%time:~6,2%
set TIME=%TIME: =0%
set BACKUP_FILE=%BACKUP_DIR%\backup-%DATE%-%TIME%.sqlite

if not exist %BACKUP_DIR% mkdir %BACKUP_DIR%

if exist %DB_FILE% (
    copy %DB_FILE% %BACKUP_FILE%
    echo [OK] Backup berhasil!
    echo File: %BACKUP_FILE%
    echo.
    echo Simpan file backup ini di lokasi aman!
) else (
    echo [ERROR] File database tidak ditemukan!
    echo Pastikan Anda menjalankan script ini di folder root project.
)

echo.
pause
