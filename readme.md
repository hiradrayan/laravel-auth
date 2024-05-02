# Laravel Auth Package

This package provides an authentication system for Laravel applications using the national ID as the primary identifier. It allows users to authenticate using their national ID and provides the necessary functionality for user registration, login, and password reset.

## Installation

1. Install the package using Composer by running the following command:
```
composer require reyhane1376/laravel-auth
```

2. Publish the package migrations by running the following command:
```
php artisan vendor:publish --tag=laravel-auth-migration
```
This will copy the migration files to your application's database/migrations directory.

3. Run the database migrations to create the required tables:
```
php artisan migrate
```

4. (Optional) If you want to customize the login form, you can publish the login form views by running the following command:
```
php artisan vendor:publish --tag=login-form
```
This will copy the login form views to your application's resources/views/auth directory. You can then modify these views to suit your needs.

## Configuration

## Usage

## License

## Contributing
