<?php

/*
 * This file is part of the Panda Ui Package.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Panda\Ui\Html\Handlers;

use DOMDocument;
use DOMElement;
use DOMNodeList;
use Exception;
use InvalidArgumentException;
use Panda\Ui\Dom\Handlers\DOMHandler;
use Symfony\Component\CssSelector\CssSelectorConverter;

/**
 * Class HTMLHandler
 * @package Panda\Ui\Html\Handlers
 */
class HTMLHandler extends DOMHandler implements HTMLHandlerInterface
{
    /**
     * Append a class to the DOMElement.
     *
     * @param DOMElement $element The DOMElement to handle.
     * @param string     $class   The class name.
     *
     * @return DOMElement
     * @throws Exception
     */
    public function addClass(DOMElement &$element, $class)
    {
        if (empty($class)) {
            return $element;
        }

        // Normalize class
        $class = trim($class);
        if (empty($class)) {
            return $element;
        }

        // Get current class
        $currentClass = trim($this->attr($element, 'class'));

        // Check if class already exists
        $classes = explode(' ', $currentClass);
        if (in_array($class, $classes)) {
            return $element;
        }

        // Append new class
        $this->appendAttr($element, 'class', $class);

        // Return the DOM Element
        return $element;
    }

    /**
     * Removes a class from the DOMElement.
     *
     * @param DOMElement $element The DOMElement to handle.
     * @param string     $class   The class name.
     *
     * @return DOMElement
     * @throws Exception
     */
    public function removeClass(DOMElement &$element, $class)
    {
        // Get current class
        $currentClass = trim($this->attr($element, 'class'));

        // Check if class doesn't exists
        $classes = explode(' ', $currentClass);
        $classKey = array_search($class, $classes);
        if ($classKey === false) {
            return $element;
        }

        // Remove class and set new class attribute
        unset($classes[$classKey]);
        $newClass = implode(' ', $classes);

        // Update attribute
        $this->attr($element, 'class', empty($newClass) ? null : $newClass);

        // Return the HTML element
        return $element;
    }

    /**
     * Check if the DOMElement has a class.
     *
     * @param DOMElement $element The DOMElement to handle.
     * @param string     $class   The class name.
     *
     * @return bool
     * @throws Exception
     */
    public function hasClass(DOMElement $element, $class)
    {
        // Get current class
        $itemClass = trim($this->attr($element, 'class'));

        // Check if class already exists
        $classes = explode(' ', $itemClass);

        return in_array($class, $classes);
    }

    /**
     * Set or get a style value.
     * This function will append the style rule in the style attribute.
     *
     * @param DOMElement $element The DOMElement to handle.
     * @param string     $name    The style name.
     * @param string     $val     If the value is NULL or FALSE, the value is considered negative and the style will be
     *                            removed from the attribute. If the value is empty string (default, null is not
     *                            included), the function will return the style value. Otherwise, the style will be
     *                            appended to the style attribute and the new attribute will be returned.
     *
     * @return DOMElement|mixed|null
     * @throws Exception
     */
    public function style(DOMElement &$element, $name, $val = '')
    {
        // Get all styles from the element
        $elementStyle = $this->attr($element, 'style');
        $elementStyle = trim($elementStyle, '; ');

        $styleArray = [];
        if (!empty($elementStyle)) {
            $styleArray = explode(';', $elementStyle);
        }
        $styles = [];
        foreach ($styleArray as $stylePair) {
            $pair = explode(':', $stylePair);
            $styles[trim($pair[0])] = trim($pair[1]);
        }

        // If value is null or false, remove attribute
        if (is_null($val) || (is_bool($val) && $val === false)) {
            unset($styles[$name]);
        } elseif (empty($val)) {
            if (isset($styles[$name])) {
                return $styles[$name];
            }

            return null;
        } else {
            $styles[$name] = $val;
        }

        // Pack all styles into one value
        $styleArray = [];
        foreach ($styles as $name => $value) {
            $pieces = [$name, $value];
            $styleArray[] = implode(': ', $pieces);
        }
        $elementStyle = implode('; ', $styleArray);

        // Set style attribute
        $this->attr($element, 'style', (empty($elementStyle) ? null : $elementStyle));

        // Return the HTML element
        return $element;
    }

    /**
     * Get or Set inner HTML.
     * Returns the inner html of the element if no content is given.
     * Sets the innerHTML of an element elsewhere.
     *
     * @param DOMElement $element         The DOMElement to handle.
     * @param string     $value           The html value to be set.
     *                                    If empty, it returns the innerHTML of the element.
     * @param bool       $faultTolerant   Indicates whenever innerHTML will try to fix (well format html) the inserted
     *                                    string value.
     * @param bool       $convertEncoding Option to convert the encoding of the value to UTF-8.
     *
     * @return DOMElement|mixed
     * @throws InvalidArgumentException
     */
    public function innerHTML(DOMElement &$element, $value = null, $faultTolerant = true, $convertEncoding = true)
    {
        // If value is null, return inner HTML
        if (is_null($value)) {
            $inner = '';
            foreach ($element->childNodes as $child) {
                $inner .= $element->ownerDocument->saveHTML($child);
            }

            return $inner;
        }

        // If no value, empty the html
        if (empty($value)) {
            // Empty the element
            for ($x = $element->childNodes->length - 1; $x >= 0; $x--) {
                $element->removeChild($element->childNodes->item($x));
            }

            return $this;
        }

        // Empty the element before adding new html
        $this->innerHTML($element, '');

        $f = $element->ownerDocument->createDocumentFragment();
        // appendXML() expects well-formed markup (XHTML)
        $result = @$f->appendXML($value);

        if ($result) {
            if ($f->hasChildNodes()) {
                $element->appendChild($f);
            }
        } else {
            // Create a new Document
            $f = new DOMDocument('1.0', 'UTF-8');

            // $value is probably ill-formed
            if ($convertEncoding) {
                $value = mb_convert_encoding($value, 'HTML-ENTITIES', 'UTF-8');
            }

            // Using <htmlfragment> will generate a warning, but so will bad HTML
            // (and by this point, bad HTML is what we've got).
            // We use it (and suppress the warning) because an HTML fragment will
            // be wrapped around <html><body> tags which we don't really want to keep.
            // Note: despite the warning, if loadHTML succeeds it will return true.
            $result = @$f->loadHTML('<htmlfragment>' . $value . '</htmlfragment>');
            if ($result && $faultTolerant) {
                $import = $f->getElementsByTagName('htmlfragment')->item(0);
                foreach ($import->childNodes as $child) {
                    $importedNode = $element->ownerDocument->importNode($child, true);
                    $this->append($element, $importedNode);
                }
            } else {    // Could not fix ill-html or we don't want to.
                return true;
            }
        }

        // Return the HTML element
        return $element;
    }

    /**
     * Get the DOMElement outer html.
     *
     * @param DOMElement $element The DOMElement to handle.
     *
     * @return string
     */
    public function outerHTML(DOMElement $element)
    {
        // Get outer html
        return $element->ownerDocument->saveHTML($element);
    }

    /**
     * Selects nodes in the html document that match a given css selector.
     *
     * @param DOMDocument $document The DOMDocument to select to.
     * @param string      $selector The css selector to search for in the html document.
     *                              It does not support pseudo-* for the moment and only supports simple equality
     *                              attribute-wise. Can hold multiple selectors separated with comma.
     * @param mixed       $context  Can either be a DOMElement as the context of the search, or a css selector.
     *                              If the selector results in multiple DOMNodes, then the first is selected as the
     *                              context.
     *
     * @return DOMNodeList|false
     * @throws InvalidArgumentException
     */
    public function select(DOMDocument $document, $selector, $context = null)
    {
        // Get xpath from css selector
        $converter = new CssSelectorConverter();
        $xpath = $converter->toXPath($selector);

        // Get the context node if css context
        if (!empty($context) && is_string($context)) {
            $ctxList = $this->select($document, $context);
            if (empty($ctxList) || empty($ctxList->length)) {
                return false;
            }

            $context = $ctxList->item(0);
        }

        // Evaluate xpath and return the node list
        return $this->evaluate($document, $xpath, $context);
    }
}
