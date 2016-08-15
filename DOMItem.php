<?php

/*
 * This file is part of the Panda framework Ui component.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Panda\Ui;

use DOMElement;
use DOMException;
use DOMText;
use Exception;
use InvalidArgumentException;
use Panda\Ui\Contracts\Handlers\DOMHandlerInterface;

/**
 * Abstract Document Object Model Item Class.
 * This DOMItem implements extended DOMElement functionality.
 *
 * @package Panda\Ui
 *
 * @version 0.1
 */
class DOMItem extends DOMElement
{
    /**
     * @var DOMPrototype
     */
    protected $DOMDocument;

    /**
     * Create a new DOM Item.
     *
     * @param DOMPrototype   $DOMDocument
     * @param string         $name
     * @param string|DOMItem $value
     * @param string         $namespaceURI
     */
    public function __construct(DOMPrototype $DOMDocument, $name, $value = '', $namespaceURI = '')
    {
        // Create owner DOMDocument to be able to have the element as writable
        $this->DOMDocument = $DOMDocument;

        // Create DOMElement
        parent::__construct($name, '', $namespaceURI);
        $this->DOMDocument->appendChild($this);

        // Check if the content a DOMNode to append
        if (gettype($value) == 'string') {
            $valueNode = new DOMText($value);
        } elseif (gettype($value) == 'object' && $value instanceof self) {
            $valueNode = $value;
        }

        // Append value node
        if (!empty($valueNode)) {
            $this->append($valueNode);
        }
    }

    /**
     * Get or set an attribute for a given DOMElement.
     *
     * @param string $name     The name of the attribute.
     * @param mixed  $value    If the value is null or false, the value is considered negative and the attribute
     *                         will be removed. If the value is empty string(default, null is not included), the
     *                         function will return the attribute value. Otherwise, the attribute will be set with
     *                         the new value and the new value will be returned.
     * @param bool   $validate Validate the attribute value for special cases (id)
     *
     * @return string If the given value is empty, it returns True if the attribute is removed, False otherwise.If the
     *                given value is empty, it returns True if the attribute is removed, False otherwise. It returns
     *                the new attribute otherwise.
     *
     * @throws Exception
     */
    public function attr($name, $value = '', $validate = false)
    {
        return $this->getDOMHandler()->attr($this, $name, $value, $validate);
    }

    /**
     * Get or set a series of attributes (in the form of an array) into a DOMElement
     *
     * @param array $value The array of attributes.
     *                     The key is the name of the attribute.
     *
     * @return array
     */
    public function attrs($value = [])
    {
        return $this->getDOMHandler()->attrs($this, $value);
    }

    /**
     * Append a value into an attribute with a space between.
     *
     * @param string $name  The name of the attribute
     * @param string $value The value to be appended.
     *
     * @return string The new attribute value.
     *
     * @throws Exception
     */
    public function appendAttr($name, $value)
    {
        return $this->getDOMHandler()->appendAttr($this, $name, $value);
    }

    /**
     * Sets or gets the nodeValue of the given DOMElement.
     * Returns the old value or the DOMElement if value is set.
     *
     * @param string $value The value to be set.
     *                      If empty, the element's value will be returned.
     *
     * @return string The node value (old or new).
     */
    public function nodeValue($value = null)
    {
        return $this->getDOMHandler()->nodeValue($this, $value);
    }

    /**
     * Append an element as a child.
     *
     * @param DOMElement $element
     *
     * @return $this
     *
     * @throws InvalidArgumentException
     */
    public function append(&$element)
    {
        return $this->getDOMHandler()->append($this, $element);
    }

    /**
     * Prepends (appends first in the list) a DOMElement.
     *
     * @param DOMItem $element The child element.
     *
     * @return $this
     *
     * @throws InvalidArgumentException
     */
    public function prepend(&$element)
    {
        return $this->getDOMHandler()->prepend($this, $element);
    }

    /**
     * Remove the DOMItem from the parent
     *
     * @throws DOMException
     */
    public function remove()
    {
        return $this->getDOMHandler()->remove($this);
    }

    /**
     * Replace the DOMItem.
     *
     * @param DOMItem $element The item to replace.
     *
     * @return $this The new element.
     *
     * @throws DOMException
     */
    public function replace($element)
    {
        return $this->getDOMHandler()->replace($this, $element);
    }

    /**
     * @return DOMPrototype
     */
    public function getDOMDocument()
    {
        return $this->DOMDocument;
    }

    /**
     * @return DOMHandlerInterface
     */
    public function getDOMHandler()
    {
        return $this->getDOMDocument()->getDOMHandler();
    }
}
