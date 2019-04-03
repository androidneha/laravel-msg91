<?php

namespace Laravel\Msg91\Message;

/**
 * Class Msg91Message
 * @package Laravel\Msg91\Message
 */
class Msg91Message
{
    /**
     * @var string
     */
    public $country;

    /**
     * @var string
     */
    public $message;

    /**
     * @var int
     */
    public $route;

    /**
     * @var string
     */
    public $sender;

    /**
     * @param string $message
     * @return $this
     */
    public function message($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return $this
     */
    public function promotional()
    {
        return $this->route(1);
    }

    /**
     * @param int $route
     * @return $this
     */
    public function route($route)
    {
        $this->route = $route;
        return $this;
    }

    /**
     * @param string $sender
     * @return $this
     */
    public function sender($sender)
    {
        $this->sender = $sender;
        return $this;
    }

    /**
     * @return $this
     */
    public function transactional()
    {
        return $this->route(4);
    }
}
