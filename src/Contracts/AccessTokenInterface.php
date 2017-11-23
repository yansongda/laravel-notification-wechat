<?php

namespace Yansongda\LaravelNotificationWechat\Contracts;

interface AccessTokenInterface
{
    /**
     * Get access token.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @return string
     */
    public function getAccessToken();
}
