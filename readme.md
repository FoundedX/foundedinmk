#Founded in Macedonia
Developed at [G6](http://g6solutions.com)

###Requirements

* PHP >= 5.4
* MCrypt PHP extension
* Apache/nginx web server
* Relational database (tested with PostgreSQL and MySQL)
* [Composer](https://getcomposer.org/)
* [Bower](http://bower.io/)

###How to install

1. Clone the code from this repository
2. Install the back-end dependencies using `composer install`
3. Setup an vhost that points to the `public/` directory
4. Install the front-end dependencies using `bower install`
5. Edit the configuration files in the `app/config/` folder
5. Run `php artisan migrate` and `php artisan db:seed` to prepare the database
6. You can now log in to the admin panel using:

* email: `admin@foundedin.mk`
* password: `admin123!`

After you log in, don't forget to create a new user and delete the default one.

###Development

If you want to set your own development environment, in the `bootstrap/` folder create file called `environment.php` that returns the evn's name. For example:

```php
<?php
    return "dev";
```

Then in the `config/` folder create new one with the environment's name and inside it put the changed configuration values.