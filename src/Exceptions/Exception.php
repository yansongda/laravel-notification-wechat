<?php

namespace Yansongda\LaravelNotificationWechat\Exceptions;

class Exception extends \Exception
{
    const MISSING_APPID_APPSECRET = 1;

    const GET_ACCESS_TOKEN_ERROR = 2;

    const MISSING_TOWECHAT_METHOD = 3;

    const SEND_TEMPLATE_MESSAGE_ERROR = 4;

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
     * @param string       $message
     * @param string|int   $code
     * @param array|string $raw
     */
    public function __construct($message, $code, $raw = [])
    {
        $this->raw = is_array($raw) ? $raw : [];

        parent::__construct($message, intval($code));
    }
}
