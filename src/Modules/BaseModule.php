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
     * Available services
     * @var \OtherCode\FController\Components\Services
     */
    private $services;

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
     * Load the services into the module if they have
     * not loaded already
     * @param \OtherCode\FController\Components\Services $services
     * @param \OtherCode\FController\Components\Registry $storage
     * @param \OtherCode\FController\Components\Messages $messages
     */
    public function connect(\OtherCode\FController\Components\Services $services, \OtherCode\FController\Components\Registry $storage, \OtherCode\FController\Components\Messages $messages)
    {
        if (!isset($this->services)) {
            $this->services = $services;
        }

        if (!isset($this->storage)) {
            $this->storage = $storage;
        }

        if (!isset($this->messages)) {
            $this->messages = $messages;
        }
    }

    /**
     * Provide an access to the common services
     * of the controller
     * @param string $name
     * @return object
     */
    public function __get($name)
    {
        if (isset($this->services->$name)) {
            if ($this->services->$name instanceof \Closure) {
                return $this->services[$name]($this->services, $this->storage, $this->messages);
            }
            return $this->services->$name;
        }
        return null;
    }

}
