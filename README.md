# Laravel Slug Generator

Laravel Slug Generator is a simple and user-friendly package that helps automatically create unique slugs in Laravel projects. This package generates slugs from titles, which can then be used in URLs and for SEO purposes. It offers the ability to limit the length of the slugs, use custom separators, and automatically append numbers to avoid conflicts with existing slugs in the database. This package streamlines the slug generation process, making it easy and efficient for your Laravel application.

## Version

**Current Version:** 1.1.0
## Features

- Automatically generates slugs from titles.
- Supports custom separators.
- Allows limiting the length of slugs.
- Automatically appends numbers to avoid conflicts with existing slugs in the database.

## Installation

You can install the package via Composer:

```php
composer require sarowar/laravel-unique-slug-generator

```
## Publishing Configuration

To publish the configuration file, run the following command:

```php
php artisan vendor:publish --provider="Sarowar\LaravelSlugGenerator\LaravelSlugServiceProvider"

```
- This will create a configuration file named `sarowar-slug-generator.php` in the config directory of your Laravel application. You can customize the settings in this file according to your requirements.

## Usage
Here’s a basic example of how to use the slug generator:

```php
use Sarowar\LaravelSlugGenerator\LaravelSlug;
```
```php
// Create an instance of the slug generator
$slugGenerator = new LaravelSlug();
```
```php
// Generate a unique slug
$slug = $slugGenerator->generate($model, $title, $field);
```
### In this example:

- `$model:` The model class from which the slug will be generated.
- `$title:` The value that will be used to generate the slug.
- `$field:` The field name in the model that will be used to create the slug.


## Configuration
You can customize the slug generation by modifying the `config/sarowar-slug-generator.php` file. Options include:

- `separator:` The character to use between words in the slug (default is `-`).
- `max_length:` The maximum length of the generated slug (default is `100`).

## Contributing
- Contributions are welcome! Please open an issue or submit a pull request.
