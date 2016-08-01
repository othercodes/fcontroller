<?php

namespace OtherCode\FController\Components;

/**
 * Class Registry
 * @package OtherCode\FController\Components
 */
class Registry implements \ArrayAccess, \Countable, \IteratorAggregate
{
    /**
     * Messages
     * @var array
     */
    private $registry = array();

    /**
     * @param $name
     * @param $value
     */
    public function set($name, $value)
    {
        $this->registry[strtolower($name)] = $value;
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function get($name)
    {
        if (isset($this->registry[strtolower($name)])) {
            return $this->registry[strtolower($name)];
        }
        return null;
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->set($name, $value);
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * @param string $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * @param string $offset
     * @param string $value
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    /**
     * @param string $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->registry[strtolower($offset)]);
    }

    /**
     * @param string $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->registry[strtolower($offset)]);
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator() {
        return new \ArrayIterator($this->registry);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->registry);
    }
}