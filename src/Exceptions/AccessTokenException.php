<?php

namespace Yansongda\LaravelNotificationWechat\Exceptions;

class AccessTokenException extends Exception
{
    /**
     * Error raw data.
     *
     * @var array
     */
    public $raw = [];

    /**
     * Bootstrap.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string     $message
     * @param string|int $code
     */
    public function __construct($message, $code, $raw = [])
    {
        parent::__construct($message, intval($code));
        
        $this->raw = $raw;
    }
}
