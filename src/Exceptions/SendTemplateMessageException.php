<?php

namespace Yansongda\LaravelNotificationWechat\Exceptions;

class SendTemplateMessageException extends Exception
{
    /**
     * Error raw data.
     *
     * @var array
     */
    public $raw = [];

    /**
     * Credential.
     *
     * @var Yansongda\LaravelNotificationWechat\Contracts\AccessTokenInterface
     */
    public $credential;

    /**
     * Bootstrap.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string     $message
     * @param string|int $code
     * @param Yansongda\LaravelNotificationWechat\Contracts\AccessTokenInterface | null $credential
     */
    public function __construct($message, $code, $raw = [], $credential = null)
    {
        parent::__construct($message, intval($code));
        
        $this->raw = $raw;
        $this->credential = $credential;
    }
}
