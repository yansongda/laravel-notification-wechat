<?php

namespace Yansongda\LaravelNotificationWechat;

use Illuminate\Support\Facades\Cache;
use Yansongda\LaravelNotificationWechat\Contracts\AccessTokenInterface;
use Yansongda\LaravelNotificationWechat\Exceptions\AccessTokenException;
use Yansongda\Supports\Traits\HasHttpRequest;

class Credential implements AccessTokenInterface
{
    use HasHttpRequest;

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
     * Wechat access token.
     *
     * @var string
     */
    public $accessToken;

    /**
     * Wechat accessToken getway.
     *
     * @var string
     */
    protected $baseUri = "https://api.weixin.qq.com/cgi-bin/";

    /**
     * Bootstap.
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
     * @author yansongda <me@yansongda.cn>
     *
     * @return string
     */
    public function getAccessToken()
    {
        if (! isset($this->accessToken)) {
            if (is_null($this->appid) || is_null($this->appsecret)) {
                throw new AccessTokenException("Appid or appsecret is null", 1);
            }

            $this->accessToken = Cache::remember('wechatAccessToken' . $this->appid, 118, function () {
                $data = $this->get('token', [
                    'grant_type' => 'client_credential',
                    'appid' => $this->appid,
                    'secret' => $this->appsecret,
                ]);

                if (! isset($data['access_token'])) {
                    throw new AccessTokenException('Error Get AccessToken:' . $data['errmsg'], $data['errcode'], $data);
                }

                return $data['access_token'];
            });
        }

        return $this->accessToken;
    }
}

