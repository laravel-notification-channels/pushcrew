# VWO Engage (previously PushCrew) Push Notifications Channel for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravel-notification-channels/vwo-engage.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/vwo-engage)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/laravel-notification-channels/vwo-engage/master.svg?style=flat-square)](https://travis-ci.org/laravel-notification-channels/vwo-engage)
[![StyleCI](https://styleci.io/repos/70140859/shield)](https://styleci.io/repos/70140859)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/:sensio_labs_id.svg?style=flat-square)](https://insight.sensiolabs.com/projects/:sensio_labs_id)
[![Quality Score](https://img.shields.io/scrutinizer/g/laravel-notification-channels/vwo-engage.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/vwo-engage)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/laravel-notification-channels/vwo-engage/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/vwo-engage/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel-notification-channels/vwo-engage.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/vwo-engage)

This package makes it easy to send notifications using [VWO Engage](https://vwo.com/engage) with Laravel.

## Contents

- [Installation](#installation)
    - [Setting up the VWO Engage service](#setting-up-the-vwo-engage-service)
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
composer require laravel-notification-channels/vwo-engage
```

### Setting up the VWO Engage service

Add your VWO Engage API Token to your `config/services.php`:

```php
// config/services.php
'vwo-engage' => [
    'token' => env('VWO_ENGAGE_API_TOKEN'),
]
```

## Usage

Now you can use the channel in your `via()` method inside the notification:

```php
use Illuminate\Notifications\Notification;
use NotificationChannels\Engage\EngageChannel;
use NotificationChannels\Engage\EngageMessage;

class AccountApproved extends Notification
{
    public function via($notifiable)
    {
        return [EngageChannel::class];
    }

    public function toEngage($notifiable)
    {
        return EngageMessage::create()
                    ->subject('Your account was approved!')
                    ->body('Click here to see details.')
                    ->icon('https://upload.wikimedia.org/wikipedia/commons/thumb/9/9a/Laravel.svg/231px-Laravel.svg.png')
                    ->url('https://vwo.com/engage');
    }
}
```

In order to let your Notification know which VWO Engage subscriber(s) you are targeting, add the `routeNotificationForEngage` method to your Notifiable model.

```php
public function routeNotificationForEngage()
{
    return 'VWO_ENAGE_SUBSCRIBER_ID';
}
```

You can either return a single subscriber-id, or if you want to notify multiple subscriber IDs just return an array containing all IDs.

To determine the Subscriber ID read this [FAQ](https://support.pushcrew.com/support/solutions/articles/9000064274-how-can-i-determine-the-subscriber-id-of-a-visitor-to-my-site-).

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
$ php vendor/bin/phpunit
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
