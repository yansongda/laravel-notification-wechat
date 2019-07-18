<?php

namespace Yansongda\LaravelNotificationWechat\Credentials;

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
     * Bootstrap.
     *
     * @author osi <yaoiluo@gmail.cn>
     */
    public function __construct()
    {
    }

    /**
     * Set wechat access_token.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string $token
     *
     * @return EasyWechatCredential
     */
    public function setAccessToken($token)
    {
        $this->accessToken = $token;

        return $this;
    }

    /**
     * Get wechat access_token.
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
