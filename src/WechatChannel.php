<?php

namespace Yansongda\LaravelNotificationWechat;

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

        $params = $message->toJson();

        $this->wechat->sendMessage($params);
    }
}
