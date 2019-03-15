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
        $event_key = $this->message->get('EventKey');

        if ($event_key !== null) {
            return $event_key;
        }

        return $this->_wrapper->eventKey();
    }

    public function eventName()
    {
        return $this->message->get('MsgType') . '_' . $this->message->get('Event');
    }

    public function execute($name = null)
    {
        $event_reply = new EventReply($this, $this->message, $this->config);

        return $event_reply->response();
    }
}