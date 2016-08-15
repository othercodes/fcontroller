<?php

namespace OtherCode\Examples;

/**
 * DummyOne Class
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @version 1.0
 * @package OtherCode\Examples
 */
class DummyOne extends \OtherCode\FController\Modules\BaseModule
{
    /**
     * Say hello
     * @param string $name
     * @return string
     */
    public function sayHello($name)
    {
        /**
         * We use the 'storage' property to share data
         * between modules, this is a flash shared memory
         * so the data is wiped out at the end of the execution.
         */
        $this->storage->name = $name;

        /**
         * Also we can push messages to the message queue.
         */
        $this->messages->addMessage('Running module 1');

        /**
         * Finally perform custom sample code.
         */
        return "Hello, " . $name . "!";
    }
}