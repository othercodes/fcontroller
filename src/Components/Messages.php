<?php

namespace OtherCode\FController\Components;

/**
 * Class Messages
 * @package OtherCode\FController\Components
 */
class Messages extends \OtherCode\FController\Components\Registry
{
    /**
     * Add a new message to the queue
     * @param string $message
     */
    public function addMessage($message)
    {
        $this[microtime(true)] = $message;
    }

    /**
     * Purge all the messages
     */
    public function purge()
    {
        foreach($this as $index => $message){
            unset($this->$index);
        }
    }
}