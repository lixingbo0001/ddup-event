<?php
/**
 * Created by PhpStorm.
 * User: lixingbo
 * Date: 2018/10/9
 * Time: 下午4:00
 */

namespace Ddup\Event\Config;


use Ddup\Event\Contracts\EventInterface;

class Config
{
    private $_config  = [];
    private $_dynamic = [];

    public function __construct($events, EventInterface $event)
    {
        $config = array_get($events, $event->eventName());

        if (!$config) return;

        $this->_config = [
            $config
        ];
    }

    public function register($config)
    {
        if (isset($config['name'])) {
            $this->_dynamic[] = $config;
            return;
        }

        $this->_dynamic = array_merge($this->_dynamic, $config);
    }

    public function fixed()
    {
        return $this->_config;
    }

    public function dynamic()
    {
        return $this->_dynamic;
    }

    public function config()
    {
        return array_merge($this->fixed(), $this->dynamic());
    }
}