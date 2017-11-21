<?php

namespace Yansongda\LaravelNotificationWechat;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\ServiceProvider;

class WechatServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->when(WechatChannel::class)
            ->needs(Wechat::class)
            ->give(function () {
                return new Wechat(new HttpClient());
            });
    }

    /**
     * Register any package services.
     */
    public function register()
    {
    }
}
