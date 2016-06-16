<?php

/*
 * This file is part of the Panda framework Ui component.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Panda\Ui\Html;

use Iterator;

class HTMLElementList implements Iterator
{
    /**
     * @type int
     */
    public $length;

    /**
     * @type int
     */
    private $position = 0;

    /**
     * @type HTMLElement[]
     */
    private $list;

    public function __construct()
    {
        $this->position = 0;
    }

    /**
     * Return the current element
     * @link  http://php.net/manual/en/iterator.current.php
     * @return HTMLElement Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return $this->list[$this->position];
    }

    /**
     * Move forward to next element
     * @link  http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * Return the key of the current element
     * @link  http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * Checks if current position is valid
     * @link  http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return isset($this->list[$this->position]);
    }

    /**
     * Rewind the Iterator to the first element
     * @link  http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * Retrieves a node specified by index
     *
     * @param int $index Index of the node into the collection.
     *
     * @return HTMLElement The node at the indexth position in the DOMNodeList, or &null; if that is not a valid index.
     */
    public function item($index)
    {
        return $this->list[$index];
    }

    /**
     * Push an element in the list.
     *
     * @param HTMLElement $element
     *
     * @return $this
     */
    public function push($element)
    {
        array_push($this->list, $element);

        return $this;
    }

    /**
     * Push an element in the list.
     *
     * @return HTMLElement
     */
    public function popup()
    {
        return array_pop($this->list);
    }
}