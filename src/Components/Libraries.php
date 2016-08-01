<?php

namespace OtherCode\FController\Components;


/**
 * Class Libraries
 * @package OtherCode\FController\Components
 */
class Libraries extends \OtherCode\FController\Components\Registry
{
    /**
     * Libraries constructor.
     * @param array $libraries
     */
    public function __construct(array $libraries = array())
    {
        foreach ($libraries as $name => $library) {
            $this->set($name, $library);
        }
    }
}