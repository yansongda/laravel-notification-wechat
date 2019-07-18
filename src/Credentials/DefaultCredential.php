<?php

namespace Yansongda\LaravelNotificationWechat\Credentials;

use Illuminate\Support\Facades\Cache;
use Yansongda\LaravelNotificationWechat\Contracts\AccessTokenInterface;
use Yansongda\LaravelNotificationWechat\Exceptions\AccessTokenException;
use Yansongda\Supports\Traits\HasHttpRequest;

class DefaultCredential implements AccessTokenInterface
{
    use HasHttpRequest;

    /**
     * Wechat access token.
     *
     * @var string
     */
    protected $accessToken;

    /**
     * Wechat appid.
     *
     * @var string
     */
    protected $appid;

    /**
     * Wechat appsecret.
     *
     * @var string
     */
    protected $appsecret;

    /**
     * Wechat accessToken gateway.
     *
     * @var string
     */
    protected $baseUri = 'https://api.weixin.qq.com/cgi-bin/';

    /**
     * Bootstrap.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string|null $appid
     * @param string|null $appsecret
     */
    public function __construct($appid = null, $appsecret = null)
    {
        $this->appid = $appid;
        $this->appsecret = $appsecret;
    }

    /**
     * Set wechat access_token.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string $token
     *
     * @return DefaultCredential
     */
    public function setAccessToken($token)
    {
        $this->accessToken = $token;

        return $this;
    }

    /**
     * Get wechat access_token.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @throws AccessTokenException
     *
     * @return string
     */
    public function getAccessToken()
    {
        if (isset($this->accessToken)) {
            return $this->accessToken;
        }

        if (!is_null(Cache::get('wechatAccessToken'))) {
            return Cache::get('wechatAccessToken');
        }

        if (is_null($this->appid) || is_null($this->appsecret)) {
            throw new AccessTokenException('Appid or appsecret is null', AccessTokenException::MISSING_APPID_APPSECRET);
        }

        $response = $this->requestForAccessToken();

        Cache::put('wechatAccessToken'.$this->appid, $response['access_token'], $response['expires_in']);

        $this->accessToken = $response['access_token'];

        return $this->accessToken;
    }

    /**
     * requestForAccessToken.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @throws AccessTokenException
     *
     * @return array
     */
    protected function requestForAccessToken()
    {
        $data = $this->get('token', [
            'grant_type' => 'client_credential',
            'appid'      => $this->appid,
            'secret'     => $this->appsecret,
        ]);

        if (!isset($data['access_token'])) {
            throw new AccessTokenException('Error Get AccessToken:'.$data['errmsg'], $data['errcode'], $data);
        }

        return $data;
    }
}
