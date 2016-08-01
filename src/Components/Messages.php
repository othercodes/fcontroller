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
     * @param string $text
     * @param null|string $type
     */
    public function addMessage($text, $type = null)
    {
        $this->set(null, new \OtherCode\FController\Components\Messages\Message($text, $type));
    }

    /**
     * Purge all the messages
     */
    public function purge()
    {
        foreach ($this as $index => $message) {
            unset($this->$index);
        }
    }
}