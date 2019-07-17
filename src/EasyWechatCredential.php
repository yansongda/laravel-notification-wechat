<?php

namespace Yansongda\LaravelNotificationWechat;

use Yansongda\LaravelNotificationWechat\Contracts\AccessTokenInterface;

class EasyWechatCredential implements AccessTokenInterface
{
    /**
     * Wechat access token.
     *
     * @var string
     */
    public $accessToken;

    /**
     * Bootstap.
     *
     * @author osi <yaoiluo@gmail.cn>
     */
    public function __construct()
    {
    }
    /**
     * Set wechat accesstoken.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string $token
     */
    public function setAccessToken($token)
    {
        $this->accessToken = $token;

        return $this;
    }

    /**
     * Get wechat accesstoken.
     *
     * @author osi <yaoiluo@gmail.cn>
     *
     * @return string
     */
    public function getAccessToken()
    {
        if (!isset($this->accessToken)) {
            $app = app('wechat.official_account');
            return $app->access_token->getToken()['access_token'];
        }

        return $this->accessToken;
    }
}
