<?php namespace OtherCode\FController\Core;

/**
 * Core of the controller
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @version 1.0
 * @package OtherCode\FController\Core
 */
abstract class Core
{
    /**
     * Core version
     */
    const VERSION = 1.0;

    /**
     * The registry of all modules
     * @var array
     */
    protected $modules = array();

    /**
     * The registry of all libraries
     * @var array
     */
    protected $libraries = array(
        'rest' => '\OtherCode\Rest\Rest'
    );

    /**
     * Class constructor
     */
    protected function __construct()
    {

        /**
         * foreach default library we have to
         * perform the complete registration
         */
        foreach ($this->libraries as $name => $library) {

            /**
             * if the name is used we check if the
             * body of the library is a string we have
             * to replace it with a instance of the library
             */
            if (is_string($this->libraries[$name])) {

                /**
                 * finally we check if the string is actually  a valid class name, if
                 * it is, we create a new instance of the library, otherwise we delete
                 * that entry to avoid malfunctions
                 */
                unset($this->libraries[$name]);

                if (class_exists($library)) {
                    /**
                     * Finally instantiate and register the library
                     */
                    $instance = new $library();
                    $this->registerLibrary($name, $instance);

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
            $this->modules[$name] = $module;
            return true;
        }
        return false;

    }

    /**
     * Un register a module
     * @param $name string
     */
    public function unregisterModule($name)
    {
        if (array_key_exists($name, $this->modules)) {
            unset($this->modules[$name]);
        }
    }

    /**
     * Register and instantiate a new library
     * @param string $name string
     * @param object $library
     * @return boolean
     */
    protected function registerLibrary($name, $library)
    {
        $name = strtolower($name);

        if (!array_key_exists($name, $this->libraries)) {
            $this->libraries[$name] = $library;
            return true;
        }
        return false;
    }

    /**
     * Un register a library
     * @param $key
     */
    public function unregisterLibrary($key)
    {
        if (array_key_exists($key, $this->libraries)) {
            unset($this->libraries[$key]);
        }
    }

    /**
     * Perform the main call of the module method
     * @param string $path
     * @param mixed|null $data
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
            throw new \OtherCode\FController\Exceptions\FControllerException("Module instance not found", 404);
        }

        /**
         * Finally we have to check that the requested method exists
         * in the module
         */
        if (!method_exists($this->modules[$module], $method)) {
            throw new \OtherCode\FController\Exceptions\FControllerException("Method module requested is not available", 405);
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