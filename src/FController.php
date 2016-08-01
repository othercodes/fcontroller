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
     * Set and register a new library
     * @param string $name
     * @param string $library
     * @param mixed $parameters
     * @return $this
     */
    public function setLibrary($name, $library, $parameters = null)
    {
        $name = strtolower($name);

        if (class_exists($library, true)) {

            /**
             * instantiation and initialization of
             * each module, return true on success
             * and false on error
             */
            $instance = new $library($parameters);
            $this->registerLibrary($name, $instance);
        }
        return $this;

    }

    /**
     * Get a new instance of the requested library.
     * @param $library string Library name
     * @return null|object Library instance or false in case of fail.
     * @deprecated Will be removed on v2
     */
    public function getLibraryNewInstance($library)
    {
        return $this->getLibraryInstance($library, true);
    }

    /**
     * Get a instance of the requested library.
     * @param $library string Library name
     * @param $new boolean true to get a new instance
     * @return null|object Library instance or false in case of fail.
     */
    public function getLibraryInstance($library, $new = false)
    {
        /**
         * we check if the requested library exists
         * if is does we return a new instance of the
         * the library.
         */
        if (isset($this->libraries->$library)) {
            if ($new === true) {
                return clone $this->libraries->$library;
            } else {
                return $this->libraries->$library;
            }
        }
        return null;
    }

}