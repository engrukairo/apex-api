<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About This Project
<h3>Setup</h3>

To use/run this project, first clone it or download the zip file from Github. If you downloaded the zip file, extract all the files to a folder.

Move into the folder containing the files and open your choice terminal.
Run the following commands:
- composer install
- php artisan key:generate
- php artisan jwt:generate

<h3>Database and Seeding</h3>

Now go to your database and create a database named "apexapi". If you are using password to access your database, update the .env file accordingly. After that, run the command:
- php artisan migrate

to create the database and tables. Then run:
- php artisan db:seed

The last command will create 10 users to experiment with. Go to your users table in the database and change the role for one of the users to 'admin'. All the users' password is 'password'.

<h3>Testing with Postman</h3>

<p>Using postman, let's test the routes!</p>

Login with a user's account with the role of a user to test the following routes:
- /viewallusers
- /viewuser/2 or any other id - pass the id, name, email and role as body-raw variables
- /updateuser or any other id

Use a user's account with the role of an admin to test the following routes:
- /deleteuser/2 or any other id
