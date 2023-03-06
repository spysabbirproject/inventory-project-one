## Minimum Requirements

- PHP 8.0+
- Composer 2.0+
- MySQL 5.7+
- Laravel 9.0

## How to install
- Step 1: Clone the repository
https://github.com/spysabbirproject/inventory-project-one.git

- Step 2: Install Laravel
 i) run command "composer install"
 ii) Copy .env.example file and remame .env file
 iii) run command "php artisan key:generate"

- Step 3: Edit database details 
    i) Create inventory_project_one tables in your database
    ii) Database details contact .env file in database feld
    iii) Import inventory_project_one tables

- Step 4: Mail details contact .env file in mail feld
MAIL_MAILER=Your mail mailer
MAIL_HOST=Your mail host
MAIL_PORT=Your mail port
MAIL_USERNAME= Your mail address
MAIL_PASSWORD=Your mail password
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS= Your mail address
MAIL_FROM_NAME="${APP_NAME}"

## About This Project

This is a web-based inventory Project. From here buyer can buy products. Any user can buy any products. We have an dashboard panel to control this site.

## Feature Admin Panel: 
Admin panel three roles which is:
- Admin
- Super Admin
- Manager

-   Super admin can change user role at any time. Manager and Admin have an limit that they can not be able to change Super Admins role.
-   Admin or manager who posted a product to sell they can be able to update and delete their posted product at any time.
-   Admin or manager can see stock product at any time.
-   Super admin can download stock product , expense , purchase and selling report at any time.

Manager, Admin & Super Admin panel login details:- 
Super Admin Email: superadmin@gmail.com
Admin Email: admin@gmail.com
Manager Email: manager@gmail.com
Password : 123456789

## Feature Frontend Panel
- Customer only see all category, brand and all product
- If customers face any question or any problem than send contact message

## Software Requirement
I have used those languages to create this project.

Front-End
- HTML
- CSS
- Java Scripts

Back-End: 
- PHP
- Laravel-Framework : 9
- Mysql
- Ajax
