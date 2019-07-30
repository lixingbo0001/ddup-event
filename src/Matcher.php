<?php
/**
 * Created by PhpStorm.
 * User: lixingbo
 * Date: 2018/10/9
 * Time: 下午4:00
 */

namespace Ddup\Event;


use Ddup\Event\Contracts\MatcherCallable;
use Ddup\Part\Conditions\NotEqual;
use Ddup\Part\Contracts\ConditionContract;
use Ddup\Part\Conditions\Def;
use Ddup\Part\Conditions\Equal;
use Ddup\Part\Conditions\Greater;
use Ddup\Part\Conditions\Less;
use Ddup\Part\Conditions\Preg;
use Ddup\Part\Message\MessageContract;
use Ddup\Event\Config\HookStruct;

class Matcher
{
    private $conditions = [];


    public function __construct()
    {
        $this->register(new Equal());
        $this->register(new NotEqual());
        $this->register(new Greater());
        $this->register(new Less());
        $this->register(new Preg());
    }

    public function getCondition($name):ConditionContract
    {
        if (!isset($this->conditions[$name])) return new Def();

        return $this->conditions[$name];
    }

    public function register(ConditionContract $contract)
    {
        $this->conditions[$contract->getName()] = $contract;
    }

    public function struct($config)
    {
        return new HookStruct($config);
    }

    public function call($hooks, MessageContract $message, MatcherCallable $executor)
    {
        foreach ($hooks as $hook) {

            $struct = $this->struct($hook);

            if ($this->matched($struct, $message)) {
                $executor->callback($struct, $message);
            }
        }

        return false;
    }

    private function matched(HookStruct $config, MessageContract $message)
    {
        $condition = $this->getCondition($config->condition_op);

        if (!$condition) return false;

        return $condition->matched($message, $config->condition_key, $config->condition_val);
    }
}