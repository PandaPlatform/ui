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

namespace Panda\Ui;

use DOMAttr;
use DOMDocument;
use DOMElement;
use DOMException;
use DOMNode;
use DOMText;
use Exception;
use InvalidArgumentException;

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
     * Create a new DOM Item.
     *
     * @param string         $name
     * @param string|DOMItem $value
     * @param string         $namespaceURI
     */
    public function __construct($name, $value = '', $namespaceURI = '')
    {
        // Create owner DOMDocument to be able to have the element as writable
        $DOMDocument = new DOMDocument();

        // Create DOMElement
        parent::__construct($name, '', $namespaceURI);
        $DOMDocument->appendChild($this);

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
        // If value is null or false, remove attribute
        if (is_null($value) || (is_bool($value) && $value === false)) {
            return $this->removeAttribute($name);
        }

        // If value is empty (null is empty but is caught above, except 0), get attribute
        if (empty($value) && $value !== 0) {
            return $this->getAttribute($name);
        }

        // Check if id is valid
        if ($name == 'id') {
            $match = preg_match('/^[a-zA-Z][\w\_\-\.\:]*$/i', $value);
            if (!$match && $validate) {
                throw new Exception('The given value is not valid for the given attribute name.', 1);
            }
        }

        // Set attribute
        if (is_bool($value) && $value === true) {
            $this->setAttributeNode(new DOMAttr($name));
        } else {
            $this->setAttribute($name, trim((string)$value));
        }

        return $value;
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
        if (empty($value)) {
            // Get current attributes
            $attrs = [];
            foreach ($this->attributes as $attr) {
                $attrs[$attr->name] = $attr->value;
            }

            // Return the current attributes
            return $attrs;
        } elseif (is_array($value) && count($value) > 0) {
            // Set the given attributes
            foreach ($value as $key => $val) {
                $this->attr($key, $val);
            }
        }

        return [];
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
        // Create new attribute value
        $value = trim((string)$value);
        $old_value = $this->getAttribute($name);
        $value = trim(trim((string)$old_value) . ' ' . $value);

        // Set new attribute value
        return $this->attr($name, $value);
    }

    /**
     * Inserts a data-[name] attribute.
     * It supports single value or an array of values.
     *
     * @param string $name  The data name of the attribute (data-[name])
     * @param mixed  $value The data value.
     *                      It can be a single value or an array of values.
     *
     * @return bool|string TRUE or the new value on success, FALSE on failure.
     */
    public function data($name, $value = [])
    {
        // Check if value is empty
        if (empty($value)) {
            return false;
        }

        // Set normal data attribute
        if (!is_array($value)) {
            return $this->attr('data-' . $name, $value);
        }

        // Clear empty values
        foreach ($value as $key => $attr) {
            if (empty($attr) && $attr !== 0) {
                unset($value[$key]);
            }
        }

        // Encode attribute data
        $jsonValue = json_encode($value, JSON_FORCE_OBJECT);

        // Don't add anything if empty
        $jsonValue = str_replace('{}', '', $jsonValue);

        return $this->attr('data-' . $name, $jsonValue);
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
        // If given value is null, return the current value
        if (is_null($value)) {
            return $this->nodeValue;
        }

        // Return the new value
        return $this->nodeValue = $value;
    }

    /**
     * Append an element as a child.
     *
     * @param DOMNode $element
     *
     * @return $this
     *
     * @throws InvalidArgumentException
     */
    public function append(&$element)
    {
        // Check element
        if (empty($element)) {
            throw new InvalidArgumentException('You are trying to append an empty element.');
        }

        // Import element to owner document
        $element = $this->ownerDocument->importNode($element, true);

        // Append element
        $this->appendChild($element);

        // Return the DOMItem
        return $this;
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
        if (empty($element)) {
            throw new InvalidArgumentException('You are trying to prepend an empty element.');
        }

        // Import element to owner document
        $element = $this->ownerDocument->importNode($element, true);

        // Append before first child
        if ($this->childNodes->length > 0) {
            $this->insertBefore($element, $this->childNodes->item(0));
        } else {
            $this->append($element);
        }

        // Return the DOMItem
        return $this;
    }

    /**
     * Remove the DOMItem from the parent
     *
     * @throws DOMException
     */
    public function remove()
    {
        if (empty($this->parentNode)) {
            throw new DOMException('The current DOMItem has no parent.');
        }

        // Remove the element
        $this->parentNode->removeChild($this);
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
        // Check if the element has a parent node
        if (empty($this->parentNode)) {
            throw new DOMException('The current DOMItem has no parent.');
        }

        // Import element to owner document
        $element = $this->ownerDocument->importNode($element, true);

        // Replace the element
        $this->parentNode->replaceChild($element, $this);

        return $element;
    }
}

