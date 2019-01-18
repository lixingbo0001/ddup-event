<?php
/**
 * Created by PhpStorm.
 * User: lixingbo
 * Date: 2018/10/10
 * Time: 上午11:58
 */

namespace Ddup\Event\EventProvider;


use Ddup\Event\Contracts\EventInterface;
use Ddup\Event\EventReply;
use Ddup\Part\Message\MessageContract;

class EventSystem implements EventInterface
{

    protected $message;

    public function __construct(MessageContract $message)
    {
        $this->message = $message;
    }

    public function eventKey()
    {
        $event_key = $this->message->get('key');

        if ($event_key !== null) {
            return $event_key;
        }

        return $this->eventName();
    }

    public function eventName()
    {
        return 'system_event_' . $this->message->get('event');
    }

    public function execute($name = null)
    {
        if (!is_null($name)) {
            $this->message->set('event', $name);
        }

        $event_reply = new EventReply($this, $this->message);

        return $event_reply->response();
    }
}