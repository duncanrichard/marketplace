## Description 

####Laravel 9 Starter template for Multi-language projects based on PlainAdmin Bootstrap 5 admin template

## Requirements

- PHP ^8.0.2
- Mysql 8.0
- composer ^2.0

## Usage

### 1. Clone project && install depenencies:
```
   $ composer install
```

### 2. Copy .env.example.file to new .env file, set database credentials & fill APP_URL, set config/app.php, config/lfm.php && config/laravellocalization settings as you want, then:
```
   $ php artisan key:generate
   $ php artisan optimize:clear
```

### 3. Run migrations:
```
   $ php artisan migrate
```

### 4. Create symbolic link:
```
   $ php artisan storage:link
```

## What's included & changed:

** packages:

- laravel-ide-helper --dev
- laravel-debugbar --dev
- laraveldaily/larastarters --dev
- mcamara/laravel-localization
- spatie/laravel-translatable
- unisharp/laravel-filemanager

** presets:
- [PlainAdmin Bootstrap 5 - admin dashbaord](https://plainadmin.com/)
- [Summernote - Super Simple WYSIWYG editor](https://summernote.org/)
- [Integrated LFM (file-upload) button with Summernote](https://unisharp.github.io/laravel-filemanager/)
- Migrated back to laravel-mix from Vite for compiling assets

## Contacts

- [@devsobirov](https://sobirov.uz)
- [devsobirov@gmail.com]()
