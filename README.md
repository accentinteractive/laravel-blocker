# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/accentinteractive/laravel-blocker.svg?style=flat-square)](https://packagist.org/packages/accentinteractive/laravel-blocker)
[![Total Downloads](https://img.shields.io/packagist/dt/accentinteractive/laravel-blocker.svg?style=flat-square)](https://packagist.org/packages/accentinteractive/laravel-blocker)
![GitHub Actions](https://github.com/accentinteractive/laravel-blocker/actions/workflows/main.yml/badge.svg)

Your application is hammered by malicious bots and exploit URLs. This package detects those and blocks the IP addresses. Blocked users are denied access to your application until their block expires.

1. Block exploit URLs like `/wp-admin` and `?invokefunction&function=call_user_func_array&vars[0]=phpinfo`.
2. Block user Agents like `Seznam`, `Flexbot` and `Mail.ru`.
3. Set the expiration time for IP blocks.

## Installation

Step 1: You can install the package via composer:

```bash
composer require accentinteractive/laravel-blocker
```

Step 2: Make sure to register the Middleware. 

- To use it on all requests, add it to `web` in `$middlewareGroups` in file `app/Http/Kernel.php`
- To use it on specific requests, add it to another group or to the `protected $middleware` property in file `app/Http/Kernel.php`

Step 3: You can publish the config file with:

```
php artisan vendor:publish --provider="Accentinteractive\LaravelBlocker\LaravelBlockerServiceProvider" --tag="config"
```

Step 4: there is no step 4 :)

## Usage

The package uses auto discover. The package middleware that does the checking is automatically registered.

## Config settings

You can enable both URL checking and User Agent checking in the published config file, or by setting these values in .env:

```apacheconf
URL_DETECTION_ENABLED=true
USER_AGENT_DETECTION_ENABLED=true
```

You can set the block expiration time (in seconds) in the published config file, or by setting this value in .env:

```apacheconf
AI_BLOCKER_EXPIRATION_TIME=3600
```

You can set the alle malicious URLs in the published config file, or by setting this value in .env, separated by a pipe:

```apacheconf
AI_BLOCKER_MALICIOUS_URLS='call_user_func_array|invokefunction|wp-admin|wp-login|.git|.env|install.php|/vendor'
```

You can set the alle malicious URLs in the published config file, or by setting this value in .env, separated by a pipe:

```apacheconf
AI_BLOCKER_MALICIOUS_USER_AGENTS='dotbot|linguee'
```

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email joost@accentinteractive.nl instead of using the issue tracker.

## Credits

-   [Joost van Veen](https://github.com/accentinteractive)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
