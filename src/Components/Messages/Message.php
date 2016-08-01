<?php

namespace OtherCode\FController\Components\Messages;

/**
 * Class Messages
 * @package OtherCode\FController\Components\Messages
 */
class Message
{
    /**
     * Main message text
     * @var string
     */
    public $text;

    /**
     * Message type
     * @var string
     */
    public $type;

    /**
     * Message constructor.
     * @param string $text
     * @param string $type
     */
    public function __construct($text, $type = 'info')
    {
        $this->text = $text;

        if (in_array($type, array('info', 'notice', 'error', 'warning'))) {
            $this->type = $type;
        } else {
            $this->type = 'info';
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s: %s', ucfirst($this->type), $this->text);
    }
}