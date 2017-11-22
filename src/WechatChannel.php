<?php

namespace Yansongda\LaravelNotificationWechat;

use Illuminate\Notifications\Notification;

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

        if ($message->credential != null) {
            $credential = (new Credential())->setToken($message->credential);

            $this->wechat = new Wechat($credential);
        }

        $params = $message->toJson();

        $this->wechat->sendMessage($params);
    }
}
