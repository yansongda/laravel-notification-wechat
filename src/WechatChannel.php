<?php

namespace Yansongda\LaravelNotificationWechat;

use Illuminate\Notifications\Notification;
use Yansongda\LaravelNotificationWechat\Contracts\AccessTokenInterface;

class WechatChannel
{
    /**
     * Wechat.
     *
     * @var Wechat
     */
    protected $wechat;

    /**
     * Bootstrap.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param Wechat $wechat
     */
    public function __construct(Wechat $wechat)
    {
        $this->wechat = $wechat;
    }

    /**
     * Send the given notification.
     *
     * @author yansongda <me@yansongda.cn>
     * 
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toWechat($notifiable);

        if (is_string($message->credential)) {
            $credential = (new Credential())->setAccessToken($message->credential);

            $this->wechat = new Wechat($credential);
        } elseif ($message->credential instanceof AccessTokenInterface) {
            $this->wechat = new Wechat($message->credential);
        }

        $params = $message->toJson();

        return $this->wechat->sendMessage($params);
    }
}
