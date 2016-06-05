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
use DOMElement;
use DOMNode;
use Exception;
use InvalidArgumentException;

/**
 * Abstract Document Object Model Item Class
 *
 * This DOMItem implements extended DOM functionality.
 *
 * @version    0.1
 */
class DOMItem
{
    /**
     * @type DOMPrototype
     */
    protected $DOMDocument;

    /**
     * @type DOMNode
     */
    protected $DOMElement;

    /**
     * Create a new DOM Document.
     *
     * @param DOMPrototype   $DOMDocument
     * @param string         $name
     * @param string|DOMItem $value
     */
    public function __construct(DOMPrototype $DOMDocument, $name, $value = "")
    {
        // Initialize DOMDocument
        $this->DOMDocument = $DOMDocument;

        // Check if the content is string or a DOMElement
        if (gettype($value) == "string") {
            $this->DOMElement = $this->DOMDocument->createElement($name);
            $txtNode = $this->DOMDocument->createTextNode($value);
            $this->DOMElement->appendChild($txtNode);
        } else {
            $this->DOMElement = $this->DOMDocument->createElement($name);
            if (gettype($value) == "object") {
                $this->DOMElement->appendChild($value->getDOMElement());
            }
        }
    }

    /**
     * Get or set an attribute for a given DOMElement.
     *
     * @param string $name           The name of the attribute.
     * @param mixed  $value          If the value is null or false, the value is considered negative and the attribute
     *                               will be removed. If the value is empty string(default, null is not included), the
     *                               function will return the attribute value. Otherwise, the attribute will be set with
     *                               the new value and the new value will be returned.
     * @param bool   $validate       Validate the attribute value for special cases (id)
     *
     * @return string If the given value is empty, it returns True if the attribute is removed, False otherwise.
     * If the given value is empty, it returns True if the attribute is removed, False otherwise.
     * It returns the new attribute otherwise.
     * @throws Exception
     */
    public function attr($name, $value = "", $validate = false)
    {
        // If value is null or false, remove attribute
        if (is_null($value) || (is_bool($value) && $value === false)) {
            return $this->DOMElement->removeAttribute($name);
        }

        // If value is empty (null is empty but is caught above, except 0), get attribute
        if (empty($value) && $value !== 0) {
            return $this->DOMElement->getAttribute($name);
        }

        // Check if id is valid
        if ($name == "id") {
            $match = preg_match("/^[a-zA-Z][\w\_\-\.\:]*$/i", $value);
            if (!$match && $validate) {
                throw new Exception("The given value is not valid for the given attribute name.", 1);
            }
        }

        // Set attribute
        if (is_bool($value) && $value === true) {
            $this->DOMElement->setAttributeNode(new DOMAttr($name));
        } else {
            $this->DOMElement->setAttribute($name, trim($value));
        }

        return $value;
    }

    /**
     * Get or set a series of attributes (in the form of an array) into a DOMElement
     *
     * @param array $value           The array of attributes.
     *                               The key is the name of the attribute.
     *
     * @return array
     */
    public function attrs($value = array())
    {
        if (empty($value)) {
            // Get current attributes
            $attrs = array();
            foreach ($this->DOMElement->attributes as $attr) {
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

        return array();
    }


    /**
     * Append a value into an attribute with a space between.
     *
     * @param string $name  The name of the attribute
     * @param string $value The value to be appended.
     *
     * @return string The new attribute value.
     * @throws Exception
     */
    public function appendAttr($name, $value)
    {
        // Create new attribute value
        $value = trim($value);
        $old_value = $this->DOMElement->getAttribute($name);
        $value = trim(trim($old_value) . " " . $value);

        // Set new attribute value
        return $this->attr($name, $value);
    }

    /**
     * Inserts a data-[name] attribute.
     * It supports single value or an array of values.
     *
     * @param string $name        The data name of the attribute (data-[name])
     * @param mixed  $value       The data value.
     *                            It can be a single value or an array of values.
     *
     * @return bool|string TRUE or the new value on success, FALSE on failure.
     */
    public function data($name, $value = array())
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
        $jsonValue = str_replace("{}", "", $jsonValue);

        return $this->attr('data-' . $name, $jsonValue);
    }

    /**
     * Sets or gets the nodeValue of the given DOMElement.
     * Returns the old value or the DOMElement if value is set.
     *
     * @param string $value    The value to be set.
     *                         If empty, the element's value will be returned.
     *
     * @return string The node value (old or new).
     */
    public function nodeValue($value = null)
    {
        // If given value is null, return the current value
        if (is_null($value)) {
            return $this->DOMElement->nodeValue;
        }

        // Return the new value
        return $this->DOMElement->nodeValue = $value;
    }

    /**
     * Append an element as a child.
     *
     * @param DOMItem $element
     *
     * @return DOMItem
     * @throws InvalidArgumentException
     */
    public function append($element)
    {
        // Check element
        if (empty($element)) {
            throw new InvalidArgumentException("You are trying to append an empty element.");
        }
        // Import element to the document
        $element = $this->DOMDocument->importNode($element->getDOMElement(), true);

        // Append element
        $this->DOMElement->appendChild($element);

        // Return the DOMItem
        return $this;
    }

    /**
     * Prepends (appends first in the list) a DOMElement.
     *
     * @param DOMItem $element The child element.
     *
     * @return DOMItem
     * @throws InvalidArgumentException
     */
    public function prepend($element)
    {
        if (empty($element)) {
            throw new InvalidArgumentException("You are trying to prepend an empty element.");
        }

        // Append before first child
        if ($this->getDOMElement()->childNodes->length > 0) {
            $this->getDOMElement()->insertBefore($element->getDOMElement(), $this->getDOMElement()->childNodes->item(0));
        } else {
            $this->append($element);
        }

        // Return the DOMItem
        return $this;
    }

    /**
     * Remove the DOMItem from the parent
     *
     * @throws Exception
     */
    public function remove()
    {
        // Get this element
        $thisElement = $this->getDOMElement();

        // Check if the element has a parent node
        if (empty($thisElement->parentNode)) {
            throw new Exception("The current DOMItem has no parent.");
        }

        // Remove the element
        $thisElement->parentNode->removeChild($thisElement);
    }

    /**
     * Replace the DOMItem.
     *
     * @param DOMItem $element The item to replace.
     *
     * @throws Exception
     */
    public function replace($element)
    {
        // Get this element
        $thisElement = $this->getDOMElement();

        // Check if the element has a parent node
        if (empty($thisElement->parentNode)) {
            throw new Exception("The current DOMItem has no parent.");
        }

        // Replace the element
        $thisElement->parentNode->replaceChild($element->getDOMElement(), $thisElement);
    }

    /**
     * @return DOMPrototype
     */
    public function getDOMDocument()
    {
        return $this->DOMDocument;
    }

    /**
     * @return DOMNode
     */
    public function getDOMElement()
    {
        return $this->DOMElement;
    }

    /**
     * @param DOMNode $DOMElement
     *
     * @return $this
     */
    public function setDOMElement($DOMElement)
    {
        $this->DOMElement = $DOMElement;

        return $this;
    }
}

?>