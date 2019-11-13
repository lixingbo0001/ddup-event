<?php
/**
 * Created by PhpStorm.
 * User: lixingbo
 * Date: 2018/10/10
 * Time: 上午11:58
 */

namespace Ddup\Event\EventProvider;


use Ddup\Event\Config\ConfigStruct;
use Ddup\Event\Contracts\EventInterface;
use Ddup\Event\Contracts\EventKeyInterface;
use Ddup\Event\EventReply;
use Ddup\Part\Message\MessageContract;
use Ddup\Event\Contracts\MaterialProviderInterface;


class EventWechat implements EventInterface
{

    protected $message;
    private   $config;
    private   $_wrapper;

    public function __construct(MessageContract $message, ConfigStruct $config, EventKeyInterface $wrapper)
    {
        $this->message  = $message;
        $this->config   = $config;
        $this->_wrapper = $wrapper;

        $this->_wrapper->init($this, $message);
    }

    public function eventKey()
    {
        return $this->_wrapper->eventKey();
    }

    public function eventName()
    {
        return $this->message->get('MsgType') . '_' . $this->message->get('Event');
    }

    public function execute($provider_class = null):EventReply
    {
        $event_reply = new EventReply($this, $this->message, $this->config);

        $event_reply->setReplys($this->getMaterials($provider_class));

        return $event_reply->response();
    }

    public function getMaterials($provider_class)
    {
        if (!$provider_class) {
            return [];
        }

        if (!class_exists($provider_class)) {
            throw new \Exception($provider_class . '提供者不存在');
        }

        $provider = new $provider_class;

        if ($provider instanceof MaterialProviderInterface) {
            return (array)$provider->matchAll($this);
        }

        throw new \Exception('自动回复的素材提供者需要实现 MaterialProviderInterface');
    }


}