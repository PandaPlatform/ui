<?php

/*
 * This file is part of the Panda Ui Package.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Panda\Ui\Dom\Handlers;

use DOMAttr;
use DOMDocument;
use DOMElement;
use DOMException;
use DOMNode;
use DOMNodeList;
use DOMXPath;
use Exception;
use InvalidArgumentException;

/**
 * Class DOMHandler
 * @package Panda\Ui\Dom\Handlers
 */
class DOMHandler implements DOMHandlerInterface
{
    /**
     * Get or set an attribute for a given DOMElement.
     *
     * @param DOMElement $element  The DOMElement to handle.
     * @param string     $name     The name of the attribute.
     * @param mixed      $value    If the value is null or false, the value is considered negative and the attribute
     *                             will be removed. If the value is empty string(default, null is not included), the
     *                             function will return the attribute value. Otherwise, the attribute will be set with
     *                             the new value and the new value will be returned.
     * @param bool       $validate Validate the attribute value for special cases (id)
     *
     * @return string If the given value is empty, it returns True if the attribute is removed, False otherwise.If the
     *                given value is empty, it returns True if the attribute is removed, False otherwise. It returns
     *                the new attribute otherwise.
     *
     * @throws Exception
     */
    public function attr(DOMElement &$element, $name, $value = '', $validate = false)
    {
        // If value is null or false, remove attribute
        if (is_null($value) || (is_bool($value) && $value === false)) {
            return $element->removeAttribute($name);
        }

        // If value is empty (null is empty but is caught above, except 0), get attribute
        if (empty($value) && $value !== 0) {
            return $element->getAttribute($name);
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
            $element->setAttributeNode(new DOMAttr($name));
        } else {
            // Check for array
            if (is_array($value)) {
                // Clear empty values
                foreach ($value as $key => $attr) {
                    if (empty($attr) && $attr !== 0) {
                        unset($value[$key]);
                    }
                }

                // Encode attribute data
                $jsonValue = json_encode($value, JSON_FORCE_OBJECT);

                // Don't add anything if empty
                $value = str_replace('{}', '', $jsonValue);
            }

            // Set attribute
            $element->setAttribute($name, trim((string)$value));
        }

        return $value;
    }

    /**
     * Get or set a series of attributes (in the form of an array) into a DOMElement
     *
     * @param DOMElement $element The DOMElement to handle.
     * @param array      $value   The array of attributes.
     *                            The key is the name of the attribute.
     *
     * @return array
     * @throws Exception
     */
    public function attrs(DOMElement &$element, $value = [])
    {
        if (empty($value)) {
            // Get current attributes
            $attributes = [];
            foreach ($element->attributes as $attr) {
                $attributes[$attr->name] = $attr->value;
            }

            // Return the current attributes
            return $attributes;
        } else if (is_array($value) && count($value) > 0) {
            // Set the given attributes
            foreach ($value as $key => $val) {
                $this->attr($element, $key, $val);
            }
        }

        return [];
    }

    /**
     * Append a value into an attribute with a space between.
     *
     * @param DOMElement $element The DOMElement to handle.
     * @param string     $name    The name of the attribute
     * @param string     $value   The value to be appended.
     *
     * @return string The new attribute value.
     *
     * @throws Exception
     */
    public function appendAttr(DOMElement &$element, $name, $value)
    {
        // Create new attribute value
        $value = trim((string)$value);
        $old_value = $element->getAttribute($name);
        $value = trim(trim((string)$old_value) . ' ' . $value);

        // Set new attribute value
        return $this->attr($element, $name, $value);
    }

    /**
     * Inserts a data-[name] attribute.
     * It supports single value or an array of values.
     *
     * @param DOMElement   $element The DOMElement to handle.
     * @param string       $name    The data name of the attribute (data-[name])
     * @param array|string $value   The data value.
     *                              It can be a single value or an array of values.
     *
     * @return bool|string TRUE or the new value on success, FALSE on failure.
     * @throws Exception
     */
    public function data(DOMElement &$element, $name, $value = '')
    {
        return $this->attr($element, 'data-' . $name, $value);
    }

    /**
     * Sets or gets the nodeValue of the given DOMElement.
     * Returns the old value or the DOMElement if value is set.
     *
     * @param DOMElement $element The DOMElement to handle.
     * @param string     $value   The value to be set.
     *                            If empty, the element's value will be returned.
     *
     * @return string The node value (old or new).
     */
    public function nodeValue(DOMElement &$element, $value = null)
    {
        // If given value is null, return the current value
        if (is_null($value)) {
            return $element->nodeValue;
        }

        // Return the new value
        return $element->nodeValue = $value;
    }

    /**
     * Append an element as a child.
     *
     * @param DOMElement $parent The DOMElement to handle.
     * @param DOMNode    $child  The child element.
     *
     * @return DOMElement
     *
     * @throws InvalidArgumentException
     */
    public function append(DOMElement &$parent, &$child)
    {
        // Check element
        if (empty($child)) {
            throw new InvalidArgumentException('You are trying to append an empty element.');
        }

        // Append element
        $parent->appendChild($child);

        // Return the DOMElement
        return $parent;
    }

    /**
     * Prepends (appends first in the list) a DOMElement.
     *
     * @param DOMElement $parent The DOMElement to handle.
     * @param DOMNode    $child  The child element.
     *
     * @return DOMElement
     *
     * @throws InvalidArgumentException
     */
    public function prepend(DOMElement &$parent, &$child)
    {
        if (empty($child)) {
            throw new InvalidArgumentException('You are trying to prepend an empty element.');
        }

        // Append before first child
        if ($parent->childNodes->length > 0) {
            $parent->insertBefore($child, $parent->childNodes->item(0));
        } else {
            $this->append($parent, $child);
        }

        // Return the DOMElement
        return $parent;
    }

    /**
     * Remove the DOMItem from the parent
     *
     * @param DOMElement $element The DOMElement to handle.
     *
     * @throws DOMException
     */
    public function remove(DOMElement &$element)
    {
        if (empty($element->parentNode)) {
            throw new DOMException('The current DOMItem has no parent.');
        }

        // Remove the element
        $element->parentNode->removeChild($element);
    }

    /**
     * Replace the DOMItem.
     *
     * @param DOMElement $old The DOMElement to handle.
     * @param DOMNode    $new The item to replace.
     *
     * @return DOMElement|DOMNode The new element.
     *
     * @throws Exception
     */
    public function replace(DOMElement &$old, &$new)
    {
        // Check if the element has a parent node
        if (empty($old->parentNode)) {
            throw new DOMException('The current DOMItem has no parent.');
        }

        // Replace the element
        $old->parentNode->replaceChild($new, $old);

        return $new;
    }

    /**
     * Evaluate an XPath Query on the document
     *
     * @param DOMDocument $document The DOMDocument to handle.
     * @param string      $query    The XPath query to be evaluated
     * @param DOMElement  $context  The optional contextnode can be specified for doing relative XPath queries.
     *                              By default, the queries are relative to the root element.
     *
     * @return DOMNodeList Returns a typed result if possible or a DOMNodeList containing all nodes matching the given
     *                     XPath expression. If the expression is malformed or the contextnode is invalid,
     *                     DOMXPath::evaluate() returns False.
     *
     * @throws InvalidArgumentException
     */
    public function evaluate(DOMDocument $document, $query, $context = null)
    {
        $xpath = new DOMXPath($document);
        $result = $xpath->evaluate($query, $context);
        if ($result === false) {
            throw new InvalidArgumentException('The expression is malformed or the contextnode is invalid.');
        }

        return $result;
    }
}
