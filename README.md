# Laravel MSG91 - MSG91 Integration For Laravel

### About

[MSG91](https://msg91.com) is an enterprise SMS Solution providing Bulk SMS, Transactional SMS API, Regional SMS, OTP Verification APIs, Promotional SMS via powerful, robust SMS Gateway throughout the globe.

### Registration

[Sign up](https://msg91.com/signup) for MSG91 and get the auth key from your account. You can find the `auth key` from `Dashboard > API` key after signing in.

### Installation

```bash
composer require androidneha/laravel-msg91
```

#### Laravel version < 5.5
Once the package is installed, open your `app/config/app.php` configuration file and locate the `providers` key. Add the following line to the end:

```php
Laravel\Msg91\ServiceProvider::class
```

Next, locate the `aliases` key and add the following line:

```php
'Msg91' => Laravel\Msg91\Facade::class,
```

Put the credentials and preferences in ENV with the keys `MSG91_AUTH_KEY`, `MSG91_DEFAULT_SENDER`, `MSG91_DEFAULT_ROUTE`, `MSG91_DEFAULT_COUNTRY`. If you want to customize this, publish the default configuration which will create a config file `config/msg91.php`.

```bash
$ php artisan vendor:publish
```

### Usage

1. Send an SMS to one or more numbers. See the package config file to set up API access.

    ```php

    $result = Msg91::sms('919999999999', 'Hello There!');
 
    $result = Msg91::sms('919999999999', 'Hello There!', 'TEST12');

    ```
2. Send OTP

	```php

    $result = Msg91::otp('919999999999');
   
    $result = Msg91::otp('919999999999', 'TEST12');
   
    $result = Msg91::otp('919999999999', 'TEST12', '##OTP## is your OTP, Please dont share it with anyone.');
   
	```

3. Verify OTP

	```php

	$result = Msg91::verify('919999999999', 1290); // returns true or false

	```

### License

See [LICENSE.md][license-url] file.


[license-url]: LICENSE
