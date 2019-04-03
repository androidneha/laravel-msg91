<?php

namespace Laravel\Msg91;

use Illuminate\Support\Facades\Facade as LaravelFacade;

/**
 * Class Facade
 * @package Laravel\Msg91
 *
 * @method static bool otp(string $number, string $sender = null, string $message = null)
 * @method static string|false sms(string $number, string $message, string $sender = null, int $route = null, string $country = null)
 * @method static bool verify(string $number, string $otp)
 */
class Facade extends LaravelFacade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return Client::class;
    }
}
