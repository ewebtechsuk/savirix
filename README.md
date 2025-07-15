# ressapp

This repository contains a Laravel application.

The application has been updated to require **PHP 8.2** and **Laravel 11**. See
`composer.json` for the dependency definitions.

## Running Artisan Commands

All Artisan commands must be executed from the project root where the `artisan` file lives.
For example, to view the list of available commands run:

```bash
php artisan list
```

You may run any other Artisan command in the same way:

```bash
php artisan migrate
```

## Running Tests

Tests are written with PHPUnit. After installing dependencies with Composer run the test suite from the project root:


```bash
./vendor/bin/phpunit
```

If you have PHPUnit installed globally you can simply run `phpunit` instead.

