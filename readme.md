<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Server requirements:
- **Mysql ^5.7**
- **Nginx ^1 or Apache ^2.4**
- **Git**
- **Composer**
- **Node ^12 and npm**

- PHP >= 7.2.0.
- BCMath PHP Extension.
- Ctype PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
|

##Laravel installation
If git was installed, copy this command to **console** 
```
git clone https://github.com/kingofthenight696/touch-shop.git
```

## Configuration

Public Directory
After installing Laravel, you should configure your web server's document / web root to be the **public** directory. The index.php in this directory serves as the front controller for all HTTP requests entering your application.

Directory Permissions
After installing Laravel, you may need to configure some permissions. Directories within the **storage** and the **bootstrap/cache** directories should be writable by your web server or Laravel will not run. 

Configure .env:
```
Copy and rename .env.example file to .env. 
```

Application Key:
```
php artisan key:generate
```

After that you should create database user with password and database table in general-ci and install your credentials **to .env**
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=touch-shop
DB_USERNAME=touch-shop
DB_PASSWORD=touch-shop123
```

After that you can change test admin credentials **in .env**:
```
TEST_ADMIN_EMAIL=test@test.com
TEST_ADMIN_NAME=Tester
TEST_ADMIN_PASS=11111111
```

Change APP_ENV **in .env** from local to production
```
APP_ENV=production

```

Create DB structure and install testing data to DB **in console**:
```
php artisan migrate:fresh --seed
```

Install dependencies **in console**:
```
composer install
```

Install dependencies **in console**:
```
npm install
```

Make public storage link **in console**:
```
php artisan storage:link
```

Make frontend **in console**:
```
npm run build
```
