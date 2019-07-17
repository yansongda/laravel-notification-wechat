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
        if (class_exists('EasyWeChat\Factory')) {
            // 如果用了easywechat
            $this->app->when(WechatChannel::class)
                ->needs(Wechat::class)
                ->give(function () {
                    return new Wechat(new EasyWechatCredential());
                });
        } else {
            $this->app->when(WechatChannel::class)
                ->needs(Wechat::class)
                ->give(function () {
                    return new Wechat(
                        new Credential(config('services.wechat.appid'), config('services.wechat.appsecret'))
                    );
                });
        }
    }

    /**
     * Register any package services.
     */
    public function register()
    {
    }
}
