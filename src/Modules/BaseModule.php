<?php namespace OtherCode\FController\Modules;

/**
 * Base class of a SCITController module
 * @author  <usantisteban@othercode.es>
 * @version 1.0 Beta
 * @package FController
 */
abstract class BaseModule
{

    /**
     * Array of libraries
     * @var array
     */
    private $libraries = array();

    /**
     * @param array $libraries
     */
    public function loadLibraries(Array $libraries)
    {
        $this->libraries = $libraries;
    }

    /**
     * Provide an access to the common libraries
     * of the controller
     * @param string $library
     * @return object
     */
    public function __get($library)
    {
        if (array_key_exists($library, $this->libraries)) {
            return $this->libraries[$library];
        }
        return null;
    }

}
