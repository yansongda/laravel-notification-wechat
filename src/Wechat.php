<?php

namespace Yansongda\LaravelNotificationWechat;

use Yansongda\LaravelNotificationWechat\Contracts\AccessTokenInterface;
use Yansongda\LaravelNotificationWechat\Exceptions\SendTemplateMessageException;
use Yansongda\Supports\Traits\HasHttpRequest;

class Wechat
{
    use HasHttpRequest;

    /**
     * Credential.
     *
     * @var AccessTokenInterface
     */
    public $credential;

    /**
     * Wechat api gateway.
     *
     * @var string
     */
    protected $baseUri = 'https://api.weixin.qq.com/cgi-bin/';

    /**
     * Bootstrap.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param AccessTokenInterface $credential
     */
    public function __construct(AccessTokenInterface $credential)
    {
        $this->credential = $credential;
    }

    /**
     * Send template message.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string $params
     *
     * @throws SendTemplateMessageException
     *
     * @return array
     */
    public function sendMessage($params)
    {
        $data = $this->post('message/template/send', $params, [
            'query' => [
                'access_token' => $this->credential->getAccessToken(),
            ],
        ]);

        if ($data['errcode'] != 0) {
            throw new SendTemplateMessageException($data['errmsg'], $data['errcode'], $data, $this->credential);
        }

        return $data;
    }
}
