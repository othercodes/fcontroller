<?php

namespace OtherCode\FController\Core;

/**
 * Core of the controller
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @version 1.1
 * @package OtherCode\FController\Core
 */
abstract class Core
{
    /**
     * Core version
     */
    const VERSION = 1.1;

    /**
     * The registry of all modules
     * @var array
     */
    protected $modules = array();

    /**
     * The registry of all services
     * @var \OtherCode\FController\Components\Services
     */
    protected $services;

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
     * Class constructor
     */
    protected function __construct()
    {

        $this->storage = new \OtherCode\FController\Components\Registry();
        $this->services = new \OtherCode\FController\Components\Services(array(
            'rest' => '\OtherCode\Rest\Rest'
        ));

        $this->messages = new \OtherCode\FController\Components\Messages();

        /**
         * foreach default service we have to
         * perform the complete registration
         */
        foreach ($this->services as $name => $service) {

            /**
             * if the name is used we check if the
             * body of the service is a string we have
             * to replace it with a instance of the service
             */
            if (is_string($this->services->$name)) {

                /**
                 * finally we check if the string is actually  a valid class name, if
                 * it is, we create a new instance of the service, otherwise we delete
                 * that entry to avoid malfunctions
                 */
                unset($this->services->$name);

                if (class_exists($service)) {
                    /**
                     * Finally instantiate and register the service
                     */
                    $instance = new $service();
                    $this->registerService($name, $instance);

                }
            }

        }

    }

    /**
     * Register and instantiate a new module
     * @param string $name
     * @param \OtherCode\FController\Modules\BaseModule $module
     * @return boolean
     */
    protected function registerModule($name, \OtherCode\FController\Modules\BaseModule $module)
    {
        $name = strtolower($name);

        if (!array_key_exists($name, $this->modules)) {
            $module->connect($this->services, $this->storage, $this->messages);
            $this->modules[$name] = $module;
            return true;
        }
        return false;

    }

    /**
     * Un register a module
     * @param $name string
     * @return boolean
     */
    public function unregisterModule($name)
    {
        if (array_key_exists($name, $this->modules)) {
            unset($this->modules[$name]);
            return true;
        }
        return false;
    }

    /**
     * Register and instantiate a new service
     * @param string $name string
     * @param object $service
     * @return boolean
     */
    protected function registerService($name, $service)
    {
        $name = strtolower($name);

        if (!isset($this->services->$name)) {
            $this->services->$name = $service;
            return true;
        }
        return false;
    }

    /**
     * Un register a service
     * @param string $name
     * @return boolean
     */
    public function unregisterService($name)
    {
        $name = strtolower($name);

        if (isset($this->services->$name)) {
            unset($this->services->$name);
            return true;
        }
        return false;
    }

    /**
     * Get the message queue
     * @return \OtherCode\FController\Components\Messages
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Perform the main call of the module method
     * @param string $path
     * @param object|array|null $data
     * @return mixed
     */
    public function run($path, $data = null)
    {
        $model = array();

        /**
         * first we have get the correct path
         * of the module name and method to execute
         */
        $callPath = $this->route($path);

        /**
         * once we have the module name and the
         * method name we build the payload and
         * data array.
         */
        $payload = array(
            $this->modules[$callPath->module],
            $callPath->method
        );

        if (isset($data)) {
            foreach ($data as $key => $argument) {
                $model[$key] = $argument;
            }
        }

        /**
         * here finally perform the actual call
         * to the module method requested.
         */
        return call_user_func_array($payload, $model);
    }

    /**
     * Check and build the payload call
     * @param $path
     * @return object
     * @throws \OtherCode\FController\Exceptions\FControllerException
     * @throws \OtherCode\FController\Exceptions\NotFoundException
     */
    protected function route($path)
    {
        /**
         * We check the pattern of the callPath
         * to construct the main call
         */
        if (!preg_match('/[a-zA-Z0-9]\.[a-zA-Z0-9]/', $path)) {
            throw new \OtherCode\FController\Exceptions\FControllerException("Incorrect module call pattern", 400);
        }

        /**
         * If the match is good we have to explode
         * the path in different parts.
         */
        $callPath = explode(".", $path);

        $module = strtolower($callPath[0]);
        $method = $callPath[1];

        /**
         * Now we have to check if the module that we want to
         * call is available
         */
        if (!array_key_exists($module, $this->modules)) {
            throw new \OtherCode\FController\Exceptions\NotFoundException("Module instance not found", 404);
        }

        /**
         * Finally we have to check that the requested method exists
         * in the module
         */
        if (!method_exists($this->modules[$module], $method)) {
            throw new \OtherCode\FController\Exceptions\NotFoundException("Module method requested is not available", 405);
        }

        /**
         * Build the final payload and
         * return it to the main call method
         */
        return (object)array(
            'module' => $module,
            'method' => $method
        );

    }
}