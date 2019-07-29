<?php

namespace Laravel\Msg91;

use GuzzleHttp\Client as Guzzle;

/**
 * Class Client
 * @package Laravel\Msg91
 */
class Client
{
    const ENDPOINT_OTP = 'http://control.msg91.com/api/sendotp.php';
    const ENDPOINT_OTP_VERIFY = 'http://api.msg91.com/api/verifyRequestOTP.php';
    const ENDPOINT_SMS = 'http://api.msg91.com/api/v2/sendsms';

    /**
     * @var Guzzle
     */
    protected $http;

    /**
     * @var string
     */
    protected $key;

    /**
     * Client constructor.
     * @param string $key
     */
    public function __construct($key)
    {
        $this->http = new Guzzle(['http_errors' => false]);
        $this->key = $key;
    }

    /**
     * @param string $number
     * @param string|null $sender
     * @param string|null $message
     * @return bool
     */
    public function otp($number, $sender = null, $message = null)
    {
        $guzzle6 = version_compare(Guzzle::VERSION, '6.0.0') >= 0;
        $response = $this->http->post(self::ENDPOINT_OTP, [
            $guzzle6 ? 'form_params' : 'body' => [
                'authkey' => $this->key,
                'message' => $message,
                'mobile' => $number,
                'sender' => $sender ?? config('msg91.default_sender'),
            ]
        ]);
        if ($response->getStatusCode() === 200) {
            $body = json_decode((string) $response->getBody(), true);
            return isset($body['type']) && ($body['type'] === 'success');
        }
        return false;
    }

    /**
     * @param string|array|null $number
     * @param string|array $message
     * @param string $sender
     * @param int|null $route
     * @param string|null $country
     * @return string|false
     */
    public function sms($number, $message, $sender = null, $route = null, $country = null)
    {
        if (is_string($message)) {
            $message = [[
                'message' => $message,
                'to' => (array) $number,
            ]];
        }
        $response = $this->http->post(self::ENDPOINT_SMS, [
            'headers' => ['authkey' => $this->key],
            'json' => [
                'country' => $country ?? config('msg91.default_country'),
                'route' => $route ?? config('msg91.default_route'),
                'sender' => $sender ?? config('msg91.default_sender'),
                'sms' => $message,
            ],
        ]);
        if ($response->getStatusCode() === 200) {
            $body = json_decode((string) $response->getBody(), true);
            return isset($body['type']) && ($body['type'] === 'success') ? $body['message'] : false;
        }
        return false;
    }

    /**
     * @param string $number
     * @param string $otp
     * @return bool
     */
    public function verify($number, $otp)
    {
        $guzzle6 = version_compare(Guzzle::VERSION, '6.0.0') >= 0;
        $response = $this->http->post(self::ENDPOINT_OTP_VERIFY, [
            $guzzle6 ? 'form_params' : 'body' => [
                'authkey' => $this->key,
                'mobile' => $number,
                'otp' => $otp,
            ]
        ]);
        if ($response->getStatusCode() === 200) {
            $body = json_decode((string) $response->getBody(), true);
            return isset($body['type']) && ($body['type'] === 'success');
        }
        return false;
    }
}
