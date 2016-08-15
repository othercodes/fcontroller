<?php

namespace OtherCode\Examples;

/**
 * DummyTwo Class
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @version 1.0
 * @package OtherCode\Examples
 */
class DummyTwo extends \OtherCode\FController\Modules\BaseModule
{
    /**
     * Say goodbye
     * @return string
     */
    public function sayGoodBye()
    {
        /**
         * Another message from module 2, this
         * time we push a 'warning' message
         */
        $this->messages->addMessage('Running module 2', 'warning');

        /**
         * We get a value from the shared memory.
         */
        return "GoodBye, " . $this->storage->name . "!";
    }
}