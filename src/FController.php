<?php

namespace OtherCode\FController;

/**
 * Access layer for the FController
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @version 1.0 Beta
 * @package OtherCode\FController
 */
class FController extends \OtherCode\FController\Core\Core
{
    /**
     * Store a instance of this class
     * @var \OtherCode\FController\Core\Core
     */
    private static $instance;

    /**
     * Singleton implementation
     * @return $this
     */
    public static function getInstance()
    {
        /**
         * If the static property instance
         * already have an instance of this
         * class we, return it, in other case
         * we create a new instance
         */
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * Set and register new module.
     * @param string $name
     * @param string $module
     * @param mixed $parameters
     * @return $this
     */
    public function setModule($name, $module, $parameters = null)
    {
        $name = strtolower($name);

        if (class_exists($module, true)) {

            /**
             * instantiation and initialization of
             * each module, return true on success
             * and false on error
             */
            $instance = new $module($parameters);
            $this->registerModule($name, $instance);
        }
        return $this;
    }

    /**
     * Set and register a new services
     * @param string $name
     * @param mixed $service
     * @param mixed $parameters
     * @return $this
     */
    public function setService($name, $service, $parameters = null)
    {
        $name = strtolower($name);
        if ($service instanceof \Closure) {

            /**
             * Save directly the service in the
             * container.
             */
            $this->registerService($name, $service);

        } elseif (class_exists($service, true)) {

            /**
             * instantiation and initialization of
             * each service, return true on success
             * and false on error
             */
            $this->registerService($name, new $service($parameters));
        }
        return $this;
    }

    /**
     * Get a instance of the requested service.
     * @param $service string Service name
     * @param $new boolean true to get a new instance
     * @return null|object Service instance or false in case of fail.
     */
    public function getService($service, $new = false)
    {
        /**
         * we check if the requested service exists
         * if is does we return a new instance of the
         * the service.
         */
        if (isset($this->services->$service)) {
            if ($new === true) {
                return clone $this->services->$service;
            } else {
                return $this->services->$service;
            }
        }
        return null;
    }

}