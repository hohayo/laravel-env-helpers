# Laravel Env Helpers

Extra artisan commands for [stechstudio/laravel-env-security](https://github.com/stechstudio/laravel-env-security):

- `env:edit` → Edit encrypted .env file like Rails credentials:edit
- `env:get` → Get a value from encrypted .env without manually decrypting

## Installation

```bash
composer require hohayo/laravel-env-helpers
```

## Usage

```bash
php artisan env:edit
php artisan env:edit --env=production

php artisan env:get DB_PASSWORD
php artisan env:get DB_PASSWORD --env=production
```
