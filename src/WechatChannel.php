<?php

namespace Yansongda\LaravelNotificationWechat;

use Illuminate\Notifications\Notification;
use Yansongda\LaravelNotificationWechat\Contracts\AccessTokenInterface;
use Yansongda\LaravelNotificationWechat\Exceptions\SendTemplateMessageException;

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
     * @param mixed        $notifiable
     * @param Notification $notification
     *
     * @throws Exceptions\SendTemplateMessageException
     *
     * @return array
     */
    public function send($notifiable, Notification $notification)
    {
        /* @var WechatMessage $message */
        if (!method_exists($notification, 'toWechat')) {
            throw new SendTemplateMessageException('Missing ToWechat Method In Wechat Channel', SendTemplateMessageException::MISSING_TOWECHAT_METHOD);
        }

        $message = $notification->toWechat($notifiable);

        if (is_string($message->credential)) {
            $credential = (new DefaultCredential())->setAccessToken($message->credential);

            $this->wechat = new Wechat($credential);
        } elseif ($message->credential instanceof AccessTokenInterface) {
            $this->wechat = new Wechat($message->credential);
        }

        $params = $message->toJson();

        return $this->wechat->sendMessage($params);
    }
}
