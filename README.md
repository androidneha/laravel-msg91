# Laravel MSG91 - MSG91 Integration For Laravel

### About
This package integrates [MSG91](https://msg91.com)'s SMS solution nicely with [Laravel](https://laravel.com/) 5 adding support for **Notification** & **Validator** as well.

### Registration
[Sign up](https://msg91.com/signup) for MSG91 and get the auth key from your account. You can find the `auth key` from `Dashboard > API` key after signing in.

### Installation
```bash
composer require androidneha/laravel-msg91
```

#### Laravel < 5.5
Once the package is installed, open your `app/config/app.php` configuration file and locate the `providers` key. Add the following line to the end:

```php
Laravel\Msg91\ServiceProvider::class
```

Next, locate the `aliases` key and add the following line:

```php
'Msg91' => Laravel\Msg91\Facade::class,
```

### Configuration
Put the credentials and preferences in ENV with the keys `MSG91_AUTH_KEY`, `MSG91_DEFAULT_SENDER`, `MSG91_DEFAULT_ROUTE`, `MSG91_DEFAULT_COUNTRY`. If you want to customize this, publish the default configuration which will create a config file `config/msg91.php`.

```bash
$ php artisan vendor:publish
```

### Usage

## Basic
- Send an SMS to one or more numbers.
```php
<?php

$result = Msg91::sms('919999999999', 'Hello there!');
 
$result = Msg91::sms('919999999999', 'Hello there!', 'TEST12');
 
$result = Msg91::sms(null, [
    ['to' => ['919999999999', '918888888888'], 'message' => 'Hello there!'],
    ['to' => ['917777777777'], 'message' => 'Come here!'],
], 'TEST12');
```

- Send OTP to a number.
```php
<?php

$result = Msg91::otp('919999999999');
   
$result = Msg91::otp('919999999999', 'TEST12');
   
$result = Msg91::otp('919999999999', 'TEST12', '##OTP## is your OTP, Please dont share it with anyone.');
```

- Verify OTP sent to a number.
```php
<?php

$result = Msg91::verify('919999999999', 1290); // returns true or false
```

## Notification
Include `msg91` in your notification's channels:
```php
<?php

/**
 * @param  mixed  $notifiable
 * @return array
 */
public function via($notifiable)
{
    return ['msg91'];
}
```

Define the `toMsg91` method:
```php
<?php

use Laravel\Msg91\Message\Msg91Message;

public function toMsg91()
{
    return (new Msg91Message)
        ->message(__('This is just a test message.'))
	->sender('MESG91') // [Optional] - Will pick default sender ID from MSG91_DEFAULT_SENDER or config
	->transactional(); // or promotional() [Optional] - Will pick default route from MSG91_DEFAULT_ROUTE or config
}
```

Default `routeNotificationForMsg91` method in your notifiable class:
```php
<?php

public function routeNotificationForMsg91($notification)
{
    return $this->phone_number;
}
```

Finally send the notification:
```php
<?php

$notifiable = /* some class */
$notifiable->notify(new App\Notifications\Msg91TestNotification());
```

For sending the notification to an arbitrary number, use below syntax:
```php
<?php
use Illuminate\Support\Facades\Notification

Notification::route('msg91', '919876543210')
    ->notify(new App\Notifications\Msg91TestNotification());
```

## Validator
You can validate sent OTPs using provided validation rule named `msg91_otp` as shown below:
```php
<?php

use Illuminate\Support\Facades\Validator

$data = ['number' => '9876543210', 'otp' => '1234'];

$validator = Validator::make($data, [
    'number' => ['required', 'digits:10'],
    'otp' => ['required', 'digits:4', 'msg91_otp'], // default key for source number is 'number', you can customize this using 'msg91_otp:key_name'
]);

if ($validator->fails()) {
    // report errors
}
```

### License

See [LICENSE](LICENSE) file.
