# Work in Progress!

## laravel-email-validation
Validate your email with this email validation package on email filter, typos. dns and spoofing.

## About laravel-email-validation

Solution to easily validate email.

- Validate against typos [Typo Validation](#typo-validation)

## Installation

You can install the package via composer:

```bash
composer require silassiai/laravel-email-validation
```

For typo checking you need to migrate and seed to get mail provider domains
After the seed finished, the command will cache the seeded table.

```bash
php artisan silassiai:migrate-seed
```

If you want to use a model for the previous migration you can publish that model by:

```bash
php artisan vendor:publish --tag=silassiai-models
```

## Typo Validation

You can check on typo's...