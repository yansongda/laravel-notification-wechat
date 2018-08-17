<?php

namespace Yansongda\LaravelNotificationWechat;

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
                return new Wechat(
                    new Credential(config('services.wechat.appid'), config('services.wechat.appsecret'))
                );
            });
    }

    /**
     * Register any package services.
     */
    public function register()
    {
    }
}
