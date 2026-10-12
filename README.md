<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel Installation

**1\. Point Subdomain to VPS**

Create an **A Record** in your DNS:

| **Type** | **Name** | **Value**   |
| -------- | -------- | ----------- |
| A        | school   | YOUR_VPS_IP |

**2\. Create Laravel Site in CloudPanel**

Login to CloudPanel:

https://YOUR_SERVER_IP:8443

Go to:

Sites → Add Site → Create PHP Site

Select:

Application: Laravel  
Domain: school.rabikrishnayadav.com.np  
PHP Version: 8.4 or newer

CloudPanel automatically configures Laravel's public directory correctly.

## 3\. Create Database

Inside CloudPanel:

Sites  
└─ school.rabikrishnayadav.com.np  
└─ Databases  
└─ Add Database

Save:

DB_DATABASE=school  
DB_USERNAME=rabischl  
DB_PASSWORD=Rabi@test

## 4\. Create GitHub Personal Access Token

Because the repository is private, create a token:

GitHub →

Settings  
→ Developer Settings  
→ Personal Access Tokens  
→ Fine-grained Tokens

Grant:

Repository access:  
✓ school.com  
<br/>Permissions:  
✓ Contents (Read)

Copy the token.

## 5\. Connect to Site via SSH

Find the Site User in CloudPanel.

SSH into the site:

ssh site-user@YOUR_SERVER_IP

Go to htdocs:

cd ~/htdocs

You should see:

school.rabikrishnayadav.com.np

Remove default files:

rm -rf school.rabikrishnayadav.com.np/.\* \*

## 6\. Clone Private Repository

Using your GitHub username and token:

git clone https://GITHUB_USERNAME:<GITHUB_TOKEN@github.com>/rabikrishnayadav/school.com.git school.rabikrishnayadav.com.np

Example:

git clone [https://rabikrishnayadav:github_access_token@github.com/rabikrishnayadav/school.com.git school.rabikrishnayadav.com.np](https://rabikrishnayadav:github_access_token@github.com/rabikrishnayadav/school.com.git%20school.rabikrishnayadav.com.np)

## 7\. Install Composer Dependencies

cd school.rabikrishnayadav.com.np

composer update  
composer install --no-dev --optimize-autoloader

Laravel deployment should use Composer with production optimizations.

## 8\. Configure Environment File

cp .env.example .env

Edit:

nano .env

Set:

APP_NAME="School Management System"  
APP_ENV=production  
APP_DEBUG=false  
APP_URL=<https://school.rabikrishnayadav.com.np>  
<br/>DB_CONNECTION=mysql  
DB_HOST=127.0.0.1  
DB_PORT=3306  
DB_DATABASE=school_db  
DB_USERNAME=school_user  
DB_PASSWORD=yourpassworddummy

## 9\. Generate Application Key

php artisan key:generate

**10\. Run Database Migration**
[school_db.sql](https://github.com/user-attachments/files/29280858/school_db.sql)
php artisan migrate --force

If you have seeders:

php artisan db:seed --force

**11\. Set Permissions**

chown -R rabikrishnayadav-school:rabikrishnayadav-school \\

/home/rabikrishnayadav-school/htdocs/school.rabikrishnayadav.com.np

chmod -R 775 storage  
chmod -R 775 bootstrap/cache

Laravel requires writable storage and cache directories.

or if still failing:

chmod -R 777 storage  
chmod -R 777 bootstrap/cache

(Use 777 only for testing. After it works, switch back to 775.)

**12\. Optimize Laravel**

php artisan config:cache  
php artisan route:cache  
php artisan view:cache

**13\. Enable SSL**

CloudPanel →

Sites  
→ SSL/TLS  
→ Actions  
→ New Let's Encrypt Certificate

Install SSL certificate.

**14\. Verify Document Root**

CloudPanel Laravel sites should point to:

/public

## 15\. Future Updates

When you push new code to GitHub:

cd ~/htdocs/school.rabikrishnayadav.com.np  
<br/>git pull origin main  
<br/>composer install --no-dev --optimize-autoloader  
<br/>php artisan migrate --force  
<br/>php artisan optimize:clear  
<br/>php artisan config:cache  
php artisan route:cache  
php artisan view:cache

