@echo off
echo ========================================
echo   ARVINA CLOTHING STORE - SETUP
echo ========================================
echo.

REM Check if MySQL is running
echo [1/4] Checking if MySQL is running...
tasklist /FI "IMAGENAME eq mysqld.exe" 2>NUL | find /I /N "mysqld.exe">NUL
if "%ERRORLEVEL%"=="0" (
    echo [OK] MySQL is running
) else (
    echo [ERROR] MySQL is not running!
    echo Please start MySQL from XAMPP Control Panel first.
    pause
    exit /b 1
)

echo.
echo [2/4] Setting up database...

REM Find MySQL binary path
set MYSQL_PATH=C:\xampp\mysql\bin\mysql.exe

if not exist "%MYSQL_PATH%" (
    echo [ERROR] MySQL not found at %MYSQL_PATH%
    echo Please update MYSQL_PATH in setup.bat to match your installation
    pause
    exit /b 1
)

echo [OK] MySQL found at %MYSQL_PATH%

REM Import database
echo [3/4] Creating database and tables...
"%MYSQL_PATH%" -u root -e "DROP DATABASE IF EXISTS arvina_clothing; CREATE DATABASE arvina_clothing;"

if %ERRORLEVEL% NEQ 0 (
    echo [ERROR] Failed to create database
    pause
    exit /b 1
)

echo [OK] Database created

REM Import SQL file
echo [4/4] Importing tables and sample data...
"%MYSQL_PATH%" -u root arvina_clothing < database.sql

if %ERRORLEVEL% NEQ 0 (
    echo [WARNING] Some data may already exist (this is normal)
)

echo.
echo ========================================
echo   SETUP COMPLETED SUCCESSFULLY!
echo ========================================
echo.
echo Database: arvina_clothing
echo.
echo CUSTOMER LOGIN:
echo   URL: http://localhost/arvinaClothing/login.php
echo   Username: user1
echo   Password: user123
echo.
echo ADMIN LOGIN:
echo   URL: http://localhost/arvinaClothing/admin/admin_login.php
echo   Username: admin
echo   Password: admin123
echo.
echo Make sure Apache is running in XAMPP!
echo.
pause
