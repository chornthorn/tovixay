## Asset Management System v4 with Laravel v6.16

## Installation

Step 01: Download or clone this project to your directory folder

    git clone https://github.com/chornthorn/thorn-irpct-v4.git

Step 02: Open project folder and open cmd or terminal by typing:

    composer update

   or you can typing : 
    
    composer install

Step 03: Copy file `.env.example to .env` and then open it and insert you information DB:

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=YOUR_DATABASE_NAME
    DB_USERNAME=YOUR_USERNAME_DB
    DB_PASSWORD=YOUR_PASSWORD_DB
    
Step 04: Now! please run command for generate new key on your project:

    php artisan key:generate    
    
Step 05: Please run command below for migrate and seed data demo to your project:

    php artisan migrate --seed
    
  or `php artisan migrate` , `php artisan db:seed`   

The finally run command below to run the project:

    php artisan serve 
    
or change run with change port if you want but now this example we run with port `9000`:

    php artisan serve --port=9000
  
## Using

Now please open browser if you following step above: 

        http://localhost:9000/
Login information:

 Email: `admin@gmail.com`         
 Password: `12345678`         

## Feature  Available   
Available options and their defaults:


### Coming Soon!!!

### Package use in this project:

 `AdminLTE V2` 
    
Modified by Chorn Thorn,
Power by Laravel 
