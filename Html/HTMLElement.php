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

use DOMDocument;
use Exception;
use Panda\Ui\DOMItem;
use Panda\Ui\DOMPrototype;

/**
 * HTML Element Class
 * Create HTML specific DOMElements.
 *
 * @package Panda\Ui\Html
 * @version 0.1
 */
class HTMLElement extends DOMItem
{
    /**
     * Create a new HTMLObject.
     *
     * @param DOMPrototype $HTMLDocument The DOMDocument to create the element
     * @param string       $name         The elemenet name.
     * @param string       $value        The element value.
     *                                   It can be text or another HTMLElement.
     * @param string       $id           The element id attribute value.
     * @param string       $class        The element class attribute value.
     *
     * @throws Exception
     */
    public function __construct(DOMPrototype $HTMLDocument, $name, $value = "", $id = "", $class = "")
    {
        // Create DOMItem
        parent::__construct($HTMLDocument, $name, $value);

        // Add extra attributes
        $this->attr("id", $id);
        $this->addClass($class);
    }

    /**
     * Append a class to the HTMLObject.
     *
     * @param string $class The class name.
     *
     * @return HTMLElement
     * @throws Exception
     */
    public function addClass($class)
    {
        // Normalize class
        $class = trim($class);
        if (empty($class)) {
            return $this;
        }

        // Get current class
        $currentClass = trim($this->DOMElement->getAttribute("class"));

        // Check if class already exists
        $classes = explode(" ", $currentClass);
        if (in_array($class, $classes)) {
            return $this;
        }

        // Append new class
        $this->appendAttr("class", $class);

        // Return the HTML element
        return $this;
    }

    /**
     * Removes a class from a given DOMElement.
     *
     * @param string $class The class name.
     *
     * @return HTMLElement
     * @throws Exception
     */
    public function removeClass($class)
    {
        // Get current class
        $currentClass = trim($this->attr("class"));

        // Check if class doesn't exists
        $classes = explode(" ", $currentClass);
        $classKey = array_search($class, $classes);
        if ($classKey === false) {
            return $this;
        }

        // Remove class and set new class attribute
        unset($classes[$classKey]);
        $newClass = implode(" ", $classes);

        // Update attribute
        $this->attr("class", empty($newClass) ? null : $newClass);

        // Return the HTML element
        return $this;
    }


    /**
     * Check if the given DOMElement has a given class.
     *
     * @param string $class The class name.
     *
     * @return bool True if the element has the class, false otherwise.
     * @throws Exception
     */
    public function hasClass($class)
    {
        // Get current class
        $itemClass = trim($this->attr("class"));

        // Check if class already exists
        $classes = explode(" ", $itemClass);

        return in_array($class, $classes);
    }


    /**
     * Set or get a style value.
     * This function will append the style rule in the style attribute.
     *
     * @param string $name     The style name.
     * @param string $val      If the value is NULL or FALSE, the value is considered negative and the style will be
     *                         removed from the attribute. If the value is empty string (default, null is not
     *                         included), the function will return the style value. Otherwise, the style will be
     *                         appended to the style attribute and the new attribute will be returned.
     *
     * @return HTMLElement|mixed
     */
    public function style($name, $val = "")
    {
        // Get all styles from the element
        $elementStyle = $this->attr("style");
        $elementStyle = trim($elementStyle, "; ");

        $styleArray = array();
        if (!empty($elementStyle)) {
            $styleArray = explode(";", $elementStyle);
        }
        $styles = array();
        foreach ($styleArray as $stylePair) {
            $pair = explode(":", $stylePair);
            $styles[trim($pair[0])] = trim($pair[1]);
        }

        // If value is null or false, remove attribute
        if (is_null($val) || (is_bool($val) && $val === false)) {
            unset($styles[$name]);
        } else if (empty($val)) {
            return $styles[$name];
        } else {
            $styles[$name] = $val;
        }

        // Pack all styles into one value
        $styleArray = array();
        foreach ($styles as $name => $value) {
            $pieces = array($name, $value);
            $styleArray[] = implode(": ", $pieces);
        }
        $elementStyle = implode("; ", $styleArray);

        // Set style attribute
        $this->attr("style", (empty($elementStyle) ? null : $elementStyle));

        // Return the HTML element
        return $this;
    }

    /**
     * Get or Set inner HTML.
     * Returns the inner html of the element if no content is given.
     * Sets the innerHTML of an element elsewhere.
     *
     * @param string  $value              The html value to be set.
     *                                    If empty, it returns the innerHTML of the element.
     * @param boolean $faultTolerant      Indicates whenever innerHTML will try to fix (well format html) the inserted
     *                                    string value.
     * @param boolean $convertEncoding    Option to convert the encoding of the value to UTF-8.
     *                                    It is TRUE by default.
     *
     * @return mixed|HTMLElement
     */
    public function innerHTML($value = null, $faultTolerant = true, $convertEncoding = true)
    {
        // If value is null, return inner HTML
        if (is_null($value)) {
            $inner = "";
            foreach ($this->DOMElement->childNodes as $child) {
                $inner .= $this->DOMDocument->saveXML($child);
            }

            return $inner;
        }

        // If value not null, set inner HTML

        // Empty the element
        for ($x = $this->DOMElement->childNodes->length - 1; $x >= 0; $x--) {
            $this->DOMElement->removeChild($this->DOMElement->childNodes->item($x));
        }

        // $value holds our new inner HTML
        if (empty($value == "")) {
            return $this;
        }

        $f = $this->DOMDocument->createDocumentFragment();
        // appendXML() expects well-formed markup (XHTML)
        $result = @$f->appendXML($value);

        if ($result) {
            if ($f->hasChildNodes()) {
                $this->DOMElement->appendChild($f);
            }
        } else {
            // Create a new Document
            $f = new DOMDocument("1.0", "UTF-8");

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
                    $importedNode = $this->DOMDocument->importNode($child, true);
                    $this->DOMElement->appendChild($importedNode);
                }
            } else {    // Could not fix ill-html or we don't want to.
                return true;
            }
        }

        // Return the HTML element
        return $this;
    }

    /**
     * Get the DOMElement outer html.
     *
     * @return string
     */
    public function outerHTML()
    {
        return $this->getDOMDocument()->saveHTML($this->getDOMElement());
    }
}

?>