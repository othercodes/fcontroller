<?php

namespace OtherCode\FController\Modules;


/**
 * Base class of a SCITController module
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @version 1.0 Beta
 * @package FController
 */
abstract class BaseModule
{

    /**
     * Available libraries
     * @var \OtherCode\FController\Components\Libraries
     */
    private $libraries;

    /**
     * Shared store space.
     * @var \OtherCode\FController\Components\Registry
     */
    protected $storage;

    /**
     * Messages queue
     * @var \OtherCode\FController\Components\Messages
     */
    protected $messages;

    /**
     * Load the libraries into the module if they have
     * not loaded already
     * @param \OtherCode\FController\Components\Libraries $libraries
     * @param \OtherCode\FController\Components\Registry $storage
     * @param \OtherCode\FController\Components\Messages $messages
     */
    public function connect(\OtherCode\FController\Components\Libraries $libraries, \OtherCode\FController\Components\Registry $storage, \OtherCode\FController\Components\Messages $messages)
    {
        if (!isset($this->libraries)) {
            $this->libraries = $libraries;
        }

        if (!isset($this->storage)) {
            $this->storage = $storage;
        }

        if (!isset($this->messages)) {
            $this->messages = $messages;
        }
    }

    /**
     * Provide an access to the common libraries
     * of the controller
     * @param string $name
     * @return object
     */
    public function __get($name)
    {
        return $this->libraries->$name;
    }
}
