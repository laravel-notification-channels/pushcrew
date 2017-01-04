# PushCrew Push Notifications Channel for Laravel 5.3

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravel-notification-channels/pushcrew.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/pushcrew)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/laravel-notification-channels/pushcrew/master.svg?style=flat-square)](https://travis-ci.org/laravel-notification-channels/pushcrew)
[![StyleCI](https://styleci.io/repos/70140859/shield)](https://styleci.io/repos/70140859)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/:sensio_labs_id.svg?style=flat-square)](https://insight.sensiolabs.com/projects/:sensio_labs_id)
[![Quality Score](https://img.shields.io/scrutinizer/g/laravel-notification-channels/pushcrew.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/pushcrew)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/laravel-notification-channels/pushcrew/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/pushcrew/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel-notification-channels/pushcrew.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/pushcrew)

This package makes it easy to send notifications using [PushCrew](https://pushcrew.com) with Laravel 5.3.

## Contents

- [Installation](#installation)
    - [Setting up the PushCrew service](#setting-up-the-pushcrew-service)
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
composer require laravel-notification-channels/pushcrew
```

### Setting up the PushCrew service

Add your PushCrew API Token to your `config/services.php`:

```php
// config/services.php
'pushcrew' => [
    'token' => env('PUSHCREW_API_TOKEN'),
]
```

## Usage

Now you can use the channel in your `via()` method inside the notification:

```php
use NotificationChannels\PushCrew\PushCrewChannel;
use NotificationChannels\PushCrew\PushCrewMessage;
use Illuminate\Notifications\Notification;

class AccountApproved extends Notification
{
    public function via($notifiable)
    {
        return [PushCrewChannel::class];
    }

    public function toPushCrew($notifiable)
    {
        return PushCrewMessage::create()
                    ->subject("Your account was approved!")
                    ->body("Click here to see details.")
                    ->icon('https://upload.wikimedia.org/wikipedia/commons/4/4f/Laravel_logo.png')
                    ->url('http://pushcrew.com');
    }
}
```

In order to let your Notification know which PushCrew subscriber(s) you are targeting, add the `routeNotificationForPushCrew` method to your Notifiable model.

You can either return a single subscriber-id, or if you want to notify multiple subscriber IDs just return an array containing all IDs.

```php
public function routeNotificationForPushCrew()
{
    return 'PUSHCREW_SUBSCRIBER_ID';
}
```

### Available Message methods

- `subject('')`: Accepts a string value for the title.
- `body('')`: Accepts a string value for the notification body.
- `icon('')`: Accepts an url for the icon.
- `url('')`: Accepts an url for the notification click event.

For more information [take a look here](http://api.pushcrew.com/docs/send-to-a-list-of-subscribers).

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email bellini.davide@gmail.com instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Davide Bellini](https://github.com/billmn)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
