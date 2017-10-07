<?php

namespace OtherCode\FController\Core;

/**
 * Class Container
 * @package OtherCode\FController\Components
 */
class Container implements \Psr\Container\ContainerInterface, \ArrayAccess, \Countable, \IteratorAggregate
{
    /**
     * Messages
     * @var array
     */
    private $container = array();

    /**
     * Return true if the identifier exists, false if not
     * @param string $name
     * @return bool
     */
    public function has($name)
    {
        return $this->__isset($name);
    }

    /**
     * @param $name
     * @param $value
     */
    public function set($name, $value)
    {
        $this->__set($name, $value);
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function get($name)
    {
        return $this->__get($name);
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        if (is_null($name)) {
            $this->container[] = $value;
        } else {
            $this->container[strtolower($name)] = $value;
        }
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        if (isset($this->container[strtolower($name)])) {
            return $this->container[strtolower($name)];
        }
        return null;
    }

    /**
     * @param string $name
     */
    public function __unset($name)
    {
        unset($this->container[strtolower($name)]);
    }

    /**
     * @param string $name
     * @return boolean
     */
    public function __isset($name)
    {
        return isset($this->container[strtolower($name)]);
    }

    /**
     * @param string $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->__get($offset);
    }

    /**
     * @param string $offset
     * @param string $value
     */
    public function offsetSet($offset, $value)
    {
        $this->__set($offset, $value);
    }

    /**
     * @param string $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->__isset($offset);
    }

    /**
     * @param string $offset
     */
    public function offsetUnset($offset)
    {
        $this->__unset($offset);
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->container);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->container);
    }
}