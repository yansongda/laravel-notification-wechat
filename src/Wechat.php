<?php

namespace Yansongda\LaravelNotificationWechat;

use GuzzleHttp\Client as HttpClient;

class Wechat
{
    /**
     * Http client
     *
     * @var HttpClient
     */
    protected $http;

    /**
     * Bootstrap.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param HttpClient|null $http
     */
    public function __construct(HttpClient $http = null)
    {
        $this->http = $http;
    }

    /**
     * Get HttpClient.
     *
     * @return HttpClient
     */
    protected function httpClient()
    {
        return $this->http ?: $this->http = new HttpClient();
    }

    public function sendMessage($params)
    {
        # code...
    }

    protected function sendRequest($params)
    {
        # code...
    }
}
