<?php

namespace Yansongda\LaravelNotificationWechat;

use Yansongda\Supports\Collection;

class WechatMessage
{
    /**
     * Payload.
     *
     * @var array
     */
    public $payload;

    /**
     * Credential.
     *
     * @var mixed
     */
    public $credential;

    /**
     * Create a new instance.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param mixed $credential
     */
    public static function create($credential = null)
    {
        return new static($credential);
    }

    /**
     * Bootstrap.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param mixed $credential
     */
    public function __construct($credential = null)
    {
        $this->credential = $credential;
    }

    /**
     * Target user.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string $openid
     *
     * @return WechatMessage
     */
    public function to($openid)
    {
        $this->payload['touser'] = $openid;

        return $this;
    }

    /**
     * Target template id.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string $template_id
     *
     * @return WechatMessage
     */
    public function template($template_id)
    {
        $this->payload['template_id'] = $template_id;

        return $this;
    }

    /**
     * Template's target url.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string $url
     *
     * @return WechatMessage
     */
    public function url($url)
    {
        $this->payload['url'] = $url;

        return $this;
    }

    /**
     * Template's target miniprogram.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string $appid
     * @param string $pagepath
     *
     * @return WechatMessage
     */
    public function miniprogram($appid, $pagepath)
    {
        $this->payload['miniprogram']['appid'] = $appid;
        $this->payload['miniprogram']['pagepath'] = $pagepath;

        return $this;
    }

    /**
     * Target data.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param array $data
     *
     * @return WechatMessage
     */
    public function data(array $data)
    {
        foreach ($data as $k => $v) {
            $this->payload['data'][$k] = is_array($v) ? ['value' => (new Collection($v))->first(), 'color' => (new Collection($v))->last()] : ['value' => $v, 'color' => '#173177'];
        }

        return $this;
    }

    /**
     * Convent payload to json formate.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->payload);
    }
}
