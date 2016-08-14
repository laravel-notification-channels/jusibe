# Jusibe notifications channel for Laravel 5.3

[![Latest Version on Packagist](https://img.shields.io/packagist/v/unicodeveloper/laravel-notification-channel-jusibe.svg?style=flat-square)](https://packagist.org/packages/unicodeveloper/laravel-notification-channel-jusibe)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/unicodeveloper/laravel-notification-channel-jusibe/master.svg?style=flat-square)](https://travis-ci.org/unicodeveloper/laravel-notification-channel-jusibe)
[![Quality Score](https://img.shields.io/scrutinizer/g/unicodeveloper/laravel-notification-channel-jusibe.svg?style=flat-square)](https://scrutinizer-ci.com/g/unicodeveloper/laravel-notification-channel-jusibe)
[![Total Downloads](https://img.shields.io/packagist/dt/unicodeveloper/laravel-notification-channel-jusibe.svg?style=flat-square)](https://packagist.org/packages/unicodeveloper/laravel-notification-channel-jusibe)

This package makes it easy to send [Jusibe notifications](https://jusibe.com/docs/) with Laravel 5.3.

## Contents

- [Installation](#installation)
    - [Setting up your Jusibe account](#setting-up-your-jusibe-account)
- [Usage](#usage)
    - [Available Message methods](#available-message-methods)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)

## Installation

You can install the package via composer:

``` bash
composer require unicodeveloper/laravel-notification-channel-jusibe
```

You must install the service provider:

```php
// config/app.php
'providers' => [
    ...
    NotificationChannels\Jusibe\JusibeServiceProvider::class,
],
```

### Setting up your Jusibe account

Add your Jusibe Account Key, Acess Token, and From Number (optional) to your `config/services.php`:

```php
// config/services.php
...
'jusibe' => [
    'key' => env('JUSIBE_PUBLIC_KEY'),
    'token' => env('JUSIBE_ACCESS_TOKEN'),
    'sms_from' => 'PROSPER'
]
...
```

## Usage

Now you can use the channel in your `via()` method inside the notification:

``` php
use NotificationChannels\Jusibe\JusibeChannel;
use NotificationChannels\Jusibe\JusibeMessage;
use Illuminate\Notifications\Notification;

class ValentineDateApproved extends Notification
{
    public function via($notifiable)
    {
        return [JusibeChannel::class];
    }

    public function toJusibe($notifiable)
    {
        return (new JusibeMessage())
            ->content("Your {$notifiable->service} account was approved!");
    }
}
```

In order to let your Notification know which phone are you sending to, add the `routeNotificationForJusibe` method to your Notifiable model e.g your User Model

```php
public function routeNotificationForJusibe()
{
    return $this->phone; // where `phone` is a field in your users table;
}
```

### Available Message methods

#### JusibeMessage

- `from('')`: Accepts a phone to use as the notification sender.
- `content('')`: Accepts a string value for the notification body.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email prosperotemuyiwa@gmail.com instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Prosper Otemuyiwa](https://github.com/unicodeveloper)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.