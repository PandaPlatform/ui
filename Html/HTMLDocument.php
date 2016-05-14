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

use DOMElement;
use Exception;
use InvalidArgumentException;
use Panda\Ui\DOMPrototype;
use Panda\Ui\Helpers\DOMHelper;

/**
 * HTML Document Class
 *
 * This object is a specific HTMLDocument which also provides
 * functions for html-specific actions.
 *
 * @version    0.1
 */
class HTMLDocument extends DOMPrototype
{
    /**
     * Magic method to create all html tags automatically.
     *
     * @param string $name      The function name caught.
     *                          In this function it serves as the tag name.
     * @param array  $arguments All function arguments.
     *                          They serve as the content, id and class, like DOM::create().
     *
     * @return mixed The DOMElement created or Null if the tag is not valid.
     */
    public function __call($name, $arguments)
    {
        // Get method name and check for a valid html tag
        $tag = strtolower($name);
        if (!$this->validHtmlTag($tag)) {
            return null;
        }

        // Get attributes
        $content = $arguments[0];
        $id = $arguments[1];
        $class = $arguments[2];

        // Create element
        return $this->create($tag, $content, $id, $class);
    }

    /**
     * Adds a class to the given DOMElement.
     *
     * @param DOMElement $elem  The element to add the class.
     * @param string     $class The class name.
     *
     * @return bool|string True on success, false on failure or if the class already exists.
     * @throws \Exception
     */
    public function addClass($elem, $class)
    {
        // Normalize class
        $class = trim($class);
        if (empty($class)) {
            return false;
        }

        // Get current class
        $currentClass = trim(parent::attr($elem, "class"));

        // Check if class already exists
        $classes = explode(" ", $currentClass);
        if (in_array($class, $classes)) {
            return true;
        }

        // Append new class
        return $this->appendAttr($elem, "class", $class);
    }

    /**
     * Removes a class from a given DOMElement.
     *
     * @param DOMElement $elem  The element to add the class.
     * @param string     $class The class name.
     *
     * @return bool|string True on success, false on failure or if the class already exists.
     * @throws \Exception
     */
    public function removeClass($elem, $class)
    {
        // Get current class
        $currentClass = trim($this->attr($elem, "class"));

        // Check if class doesn't exists
        $classes = explode(" ", $currentClass);
        $classKey = array_search($class, $classes);
        if ($classKey === false) {
            return false;
        }

        // Remove class and set new class attribute
        unset($classes[$classKey]);
        $newClass = implode(" ", $classes);

        return $this->attr($elem, "class", empty($newClass) ? null : $newClass);
    }


    /**
     * Check if the given DOMElement has a given class.
     *
     * @param DOMElement $elem  The element to check for the class.
     * @param string     $class The class name.
     *
     * @return bool True if the element has the class, false otherwise.
     * @throws \Exception
     */
    public function hasClass($elem, $class)
    {
        // Get current class
        $itemClass = trim($this->attr($elem, "class"));

        // Check if class already exists
        $classes = explode(" ", $itemClass);

        return in_array($class, $classes);
    }


    /**
     * Set or get a style value for the given element.
     * This function will append the style rule in the style attribute.
     *
     * @param DOMElement $elem The DOMElement to set or get the style value.
     * @param string     $name The style name.
     * @param string     $val  If the value is NULL or FALSE, the value is considered negative and the style will be
     *                         removed from the attribute. If the value is empty string (default, null is not
     *                         included), the function will return the style value. Otherwise, the style will be
     *                         appended to the style attribute and the new attribute will be returned.
     *
     * @return mixed Returns FALSE if there is an error.
     *        The new style value on success.
     * @throws Exception
     */
    public function style($elem, $name, $val = "")
    {
        if (empty($elem)) {
            throw new InvalidArgumentException("The given element is not a valid object.");
        }

        // Get all styles from the element
        $elementStyle = $this->attr($elem, "style");
        $elementStyle = trim($elementStyle, "; ");

        $styleArray = array();
        if (!empty($elementStyle))
            $styleArray = explode(";", $elementStyle);
        $styles = array();
        foreach ($styleArray as $stylePair) {
            $pair = explode(":", $stylePair);
            $styles[trim($pair[0])] = trim($pair[1]);
        }

        // If value is null or false, remove attribute
        if (is_null($val) || (is_bool($val) && $val === false))
            unset($styles[$name]);
        else if (empty($val))
            return $styles[$name];
        else
            $styles[$name] = $val;

        // Pack all styles into one value
        $styleArray = array();
        foreach ($styles as $name => $value) {
            $pieces = array($name, $value);
            $styleArray[] = implode(": ", $pieces);
        }
        $elementStyle = implode("; ", $styleArray);

        // Set style attribute
        $this->attr($elem, "style", (empty($elementStyle) ? null : $elementStyle));

        // Return the new element style
        return $elementStyle;
    }

    /**
     * Selects nodes in the html document that match a given css selector.
     *
     * @param string $selector The css selector to search for in the html document.
     *                         It does not support pseudo-* for the moment and only supports simple equality
     *                         attribute-wise. Can hold multiple selectors separated with comma.
     * @param mixed  $context  Can either be a DOMElement as the context of the search, or a css selector.
     *                         If the selector results in multiple DOMNodes, then the first is selected as the context.
     *                         It is NULL by default.
     *
     * @return mixed Returns the node list that matches the given css selector, or FALSE on malformed input.
     */
    public function select($selector, $context = null)
    {
        // Get xpath from css selector
        $xpath = DOMHelper::CSSSelector2XPath($selector);

        // Get the context node if css context
        if (!empty($context) && is_string($context)) {
            $ctxList = self::select($context);
            if (empty($ctxList) || empty($ctxList->length)) {
                return false;
            }

            $context = $ctxList->item(0);
        }

        // Evaluate xpath and return the node list
        return $this->evaluate($xpath, $context);
    }

    /**
     * Check if the given xml tag is a valid html tag.
     *
     * @param string $tag The html tag to be checked.
     *
     * @return bool True if valid, false otherwise.
     */
    private function validHtmlTag($tag)
    {
        // Temporarily return TRUE for all tags
        return true;
    }
}

?>