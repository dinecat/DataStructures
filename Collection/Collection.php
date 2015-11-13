<?php

/**
 * This file is part of the DinecatDataStructures package.
 * @copyright   2014-2015 UAB Dinecat, http://dinecat.com/
 * @license     http://dinecat.com/licenses/mit MIT License
 * @link        https://github.com/dinecat/DataStructures
 */

namespace Dinecat\DataStructures\Collection;

use Closure, ArrayIterator;

/**
 * Collection data type.
 * Inspired by Doctrine\Common\Collections\ArrayCollection.
 * @package     DinecatDataStructures
 * @subpackage  Collection
 * @author      Mykola Zyk <relo.san.pub@gmail.com>
 * @author      Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author      Jonathan Wage <jonwage@gmail.com>
 * @author      Roman Borschel <roman@code-factory.org>
 */
class Collection implements CollectionInterface
{
    /**
     * An array containing the entries of this collection.
     * @var array
     */
    private $_elements;

    /**
     * Constructor.
     * @param   array   $elements   Initial array [optional].
     */
    public function __construct(array $elements = [])
    {
        $this->_elements = $elements;
    }

    /**
     * {@inheritDoc}
     */
    public function add($value)
    {
        $this->_elements[] = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function contains($element)
    {
        return in_array($element, $this->_elements, true);
    }

    /**
     * {@inheritDoc}
     */
    public function remove($key)
    {
        if (isset($this->_elements[$key]) || array_key_exists($key, $this->_elements)) {
            $removed = $this->_elements[$key];
            unset($this->_elements[$key]);
            return $removed;
        }
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function removeElement($element)
    {
        $key = array_search($element, $this->_elements, true);
        if ($key !== false) {
            unset($this->_elements[$key]);
            return true;
        }
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function clear()
    {
        $this->_elements = [];
    }

    /**
     * {@inheritDoc}
     */
    public function isEmpty()
    {
        return !$this->_elements;
    }

    /**
     * {@inheritDoc}
     */
    public function has($key)
    {
        return isset($this->_elements[$key]) || array_key_exists($key, $this->_elements);
    }

    /**
     * {@inheritDoc}
     */
    public function get($key, $default = null)
    {
        if (isset($this->_elements[$key])) {
            return $this->_elements[$key];
        }
        return $default;
    }

    /**
     * {@inheritDoc}
     */
    public function getKeys()
    {
        return array_keys($this->_elements);
    }

    /**
     * {@inheritDoc}
     */
    public function getValues()
    {
        return array_values($this->_elements);
    }

    /**
     * {@inheritDoc}
     */
    public function count()
    {
        return count($this->_elements);
    }

    /**
     * {@inheritDoc}
     */
    public function set($key, $value)
    {
        $this->_elements[$key] = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray()
    {
        return $this->_elements;
    }

    /**
     * {@inheritDoc}
     */
    public function replaceAll(array $elements)
    {
        return $this->_elements = $elements;
    }

    /**
     * {@inheritDoc}
     */
    public function first()
    {
        return reset($this->_elements);
    }

    /**
     * {@inheritDoc}
     */
    public function last()
    {
        return end($this->_elements);
    }

    /**
     * {@inheritDoc}
     */
    public function key()
    {
        return key($this->_elements);
    }

    /**
     * {@inheritDoc}
     */
    public function current()
    {
        return current($this->_elements);
    }

    /**
     * {@inheritDoc}
     */
    public function next()
    {
        return next($this->_elements);
    }

    /**
     * {@inheritDoc}
     */
    public function exists(Closure $p)
    {
        foreach ($this->_elements as $key => $element) {
            if ($p($key, $element)) {
                return true;
            }
        }
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function filter(Closure $p)
    {
        return new static(array_filter($this->_elements, $p));
    }

    /**
     * {@inheritDoc}
     */
    public function forAll(Closure $p)
    {
        foreach ($this->_elements as $key => $element) {
            if (!$p($key, $element)) {
                return false;
            }
        }
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function map(Closure $func)
    {
        return new static(array_map($func, $this->_elements));
    }

    /**
     * {@inheritDoc}
     */
    public function mapIn(Closure $func)
    {
        $this->_elements = array_map($func, $this->_elements);
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function partition(Closure $p)
    {
        $coll1 = $coll2 = [];
        foreach ($this->_elements as $key => $element) {
            if ($p($key, $element)) {
                $coll1[$key] = $element;
            } else {
                $coll2[$key] = $element;
            }
        }
        return [new static($coll1), new static($coll2)];
    }

    /**
     * {@inheritDoc}
     */
    public function indexOf($element)
    {
        return array_search($element, $this->_elements, true);
    }

    /**
     * {@inheritDoc}
     */
    public function slice($offset, $length = null)
    {
        return array_slice($this->_elements, $offset, $length, true);
    }

    /**
     * Returns a string representation of this object.
     * @return  string
     */
    public function __toString()
    {
        return __CLASS__ . '@' . spl_object_hash($this);
    }

    /**
     * Required by interface IteratorAggregate.
     * {@inheritDoc}
     */
    public function getIterator()
    {
        return new ArrayIterator($this->_elements);
    }

    /**
     * Required by interface ArrayAccess.
     * {@inheritDoc}
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * Required by interface ArrayAccess.
     * {@inheritDoc}
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * Required by interface ArrayAccess.
     * {@inheritDoc}
     */
    public function offsetSet($offset, $value)
    {
        if (!isset($offset)) {
            $this->add($value);
        }
        $this->set($offset, $value);
    }

    /**
     * Required by interface ArrayAccess.
     * {@inheritDoc}
     */
    public function offsetUnset($offset)
    {
        return $this->remove($offset);
    }
}
