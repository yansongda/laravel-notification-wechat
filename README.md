<h1 align="center">laravel-notification-wechat</h1>

<p align="center">
    <a href="https://packagist.org/packages/yansongda/laravel-notification-wechat"><img src="https://poser.pugx.org/yansongda/laravel-notification-wechat/v/stable" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/yansongda/laravel-notification-wechat"><img src="https://poser.pugx.org/yansongda/laravel-notification-wechat/v/unstable" alt="Latest Unstable Version"></a>
    <a href="https://packagist.org/packages/yansongda/laravel-notification-wechat"><img src="https://poser.pugx.org/yansongda/laravel-notification-wechat/license" alt="License"></a>
</p>

不知道大家有没有基于 laravel 的消息通知开发过微信的模板消息通知，我反正是开发过多次了，以前开发总是写在 app 目录下，然后又一坨都写在自定义的 WechatChannel 里面，看这心里总是不舒服。多次之后，就有了这个……

## 运行环境
- PHP 5.6+
- composer

## 安装
1. composer  
`composer require yansongda/larvel-notification-wechat`

2. 注册 serviceprovider （ < laravel 5.5 ）  
`Yansongda\LaravelNotificationWechat\WechatServiceProvider::class`

## 使用
### 例子
```php
<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Yansongda\LaravelNotificationWechat\WechatChannel;
use Yansongda\LaravelNotificationWechat\WechatMessage;

class WechatNotification extends Notification
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        return [WechatChannel::class];
    }

    public function toWechat($notifiable)
    {
        $accessToken = "n2McCJoqWKRi7hJbKFOqftgtU_EX6u2ZOvIi1lpx0fZJ3YW5Oo4iIPZEpi0ecct2lHMagK84xGF5rEm_DSMKrZFfCEZiYw1yZN3nZXzFSlHM-y88sIi5-dYeeCWx9S1iHXWaAJAMCB";

        $data = [
            'first' => 'Test First',
            'keyword1' => 'keyword1',
            'keyword2' => 'keyword2',
            'keyword3' => ['keyword3', '#000000'],
            'remark' => ['Test remark', '#fdfdfd'],
        ];

        return WechatMessage::create($accessToken)
            ->to('oeTKvwYyc3PPAo3As3VRUBGppC0s')
            ->template("0qUpCTpgeYMFbjEKQ4W_D3ZNx5zUzQIfgasgqYX53mg")
            ->url('http://github.com/yansongda')
            ->data($data);
    }
}
```

### 支持的 WechatMessage 方法
- `to(string $openid)`: 设置模板消息接收人的 openID
- `template(string $templateID)`: 设置模板消息的模板 ID
- `url(string $url)`: 设置点击模板消息后跳转 url，选填
- `miniprogram(string $appid, string $pagepath)`: 设置点击模板消息后跳转的小程序，选填
- `data(array $data)`: 设置模板消息数据

### 关于微信 AccessToken
微信发送模板消息时需要传递 accesstoken ，这里有三种方法去处理，方便与您现有的微信开发框架所集成。

- 直接传递 accesstoken 值到 `WechatMessage::create($accesstoken)` 方法中，如上例所示；
- 传递一个 `Yansongda\LaravelNotificatinoWechat\Contracts\AccessTokenInterface` 类到 `WechatMessage::create($CredentialClass)` 方法；
- 直接在 config 文件夹中的 services.php 中添加 `'wechat' => ['appid' => 'xxx', 'appsecret' => 'xxx']`，系统将自动获取 accesstoken 并缓存，缓存的 key 为 `wechatAccessToken您的APPID` 您可以直接通过 laravel 的 Cache Facade 获取缓存的 accesstoken，当然，最保险的方案是通过 `(new Yansongda\LaravelNotificationWechat\Credential($appid, $appsecret))->getAccessToken()` 去获取 accesstoken。

具体可查看源码。

### 说明
1. 如果 `miniprogram` 与 `url` 同时存在，则优先使用小程序跳转，详情请参考[官方文档](https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1433751277)
2. `data()`方法接收一个数组，其 `key` 为模板消息中的关键字，`value` 可以为字符串或数组。如果为字符串，则默认颜色为 `#173177`；如果为数组，则第一个参数为显示的数据，第二个参数为字体颜色

## 代码贡献
**_欢迎 Fork 并提交 PR！_**

## LICENSE
MIT
