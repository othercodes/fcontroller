<?php

namespace OtherCode\FController\Components;


/**
 * Class Services
 * @package OtherCode\FController\Components
 */
class Services extends \OtherCode\FController\Core\Container
{
    /**
     * Libraries constructor.
     * @param array $services
     */
    public function __construct(array $services = array())
    {
        foreach ($services as $name => $service) {
            $this->set($name, $service);
        }
    }
}