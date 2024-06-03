# Work in progress

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

For typo checking you need to seed to get mail provider domains what we check for.
It will create the needed table if it does'nt exists.
We will make the list more complete in future versions, that will be updated with a cronjob.

```bash
php artisan silassiai:seed
```

## Typo Validation

Check on mail provider typo's
```bash
EmailValidationFacade::for('silas@gmayll.com')->hasTypo()
```

## Domain Validation

Check on mail provider domain's
```bash
EmailValidationFacade::for('silas@gmayll.com')->hasDomain()
```

## Credits

- [Silas de Rooy](https://github.com/Silassiai)

## License

The MIT License. Please see [License](LICENSE) for more information.
