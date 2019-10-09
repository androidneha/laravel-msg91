<?php

namespace Laravel\Msg91;

use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

/**
 * Class ServiceProvider
 * @package Laravel\Msg91
 */
class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/msg91.php', 'msg91');
        $this->app->bind(Client::class, function () {
            return new Client(config('msg91.auth_key'));
        });
        $this->app->alias(Client::class, 'msg91');
        Notification::extend('msg91', function () {
            return new Channels\Msg91Channel(app(Client::class));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('msg91_otp', function ($attribute, $value, $parameters, $validator) {
            $client = app(Client::class);
            $values = $validator->getData();
            $number = Arr::get($values, empty($parameters[0]) ? 'number' : $parameters[0]);
            return $client->verify($number, $value);
        });
    }
}
