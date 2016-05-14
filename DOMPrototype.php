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

use DOMDocument;
use DOMAttr;
use DOMElement;
use DOMNode;
use DOMXPath;
use Exception;
use InvalidArgumentException;

/**
 * Abstract Document Object Model Prototype Class
 *
 * This object can be used for any operation that has to
 * do with DOM structure and XML manipulation (XML files,
 * HTML files etc.).
 *
 * @version    0.1
 */
abstract class DOMPrototype extends DOMDocument
{
    /**
     * Create a new DOM Document.
     *
     * @param string $version
     * @param string $encoding
     */
    public function __construct($version = "1.0", $encoding = "UTF_8")
    {
        parent::__construct($version, $encoding);
    }

    /**
     * Creates and returns a DOMElement with the specified tagName and the given attributes
     *
     * @param string $tag     The tag of the element.
     * @param mixed  $content The content of the element. It can be a string or a DOMElement.
     * @param string $id      The id attribute
     * @param string $class   The class attribute
     *
     * @return DOMElement The DOMElement created
     * @throws Exception
     */
    public function create($tag = "div", $content = "", $id = "", $class = "")
    {
        // Check if the content is string or a DOMElement
        if (gettype($content) == "string") {
            $elem = $this->createElement($tag);
            $txtNode = $this->createTextNode($content);
            $elem->appendChild($txtNode);
        } else {
            $elem = $this->createElement($tag);
            if (gettype($content) == "object")
                $elem->appendChild($content);
        }


        if (!is_null($id) && !empty($id)) {
            $this->attr($elem, "id", $id);
        }

        if (!is_null($class) && !empty($class)) {
            $this->attr($elem, "class", $class);
        }

        return $elem;
    }

    /**
     * Get or set an attribute for a given DOMElement.
     *
     * @param DOMElement $element    The element to get or set the attribute.
     * @param string     $name       The name of the attribute.
     * @param mixed      $value      If the value is null or false, the value is considered negative and the attribute
     *                               will be removed. If the value is empty string(default, null is not included), the
     *                               function will return the attribute value. Otherwise, the attribute will be set with
     *                               the new value and the new value will be returned.
     * @param bool       $validate   Validate the attribute value for special cases (id)
     *
     * @return string If the given value is empty, it returns True if the attribute is removed, False otherwise.
     * If the given value is empty, it returns True if the attribute is removed, False otherwise.
     * It returns the new attribute otherwise.
     * @throws Exception
     */
    public function attr($element, $name, $value = "", $validate = false)
    {
        if (empty($element)) {
            throw new InvalidArgumentException("The given element is not a valid object.");
        }

        // If value is null or false, remove attribute
        if (is_null($value) || (is_bool($value) && $value === false)) {
            return $element->removeAttribute($name);
        }

        // If value is empty (null is empty but is caught above, except 0), get attribute
        if (empty($value) && $value !== 0) {
            return $element->getAttribute($name);
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
            $element->setAttributeNode(new \DOMAttr($name));
        } else {
            $element->setAttribute($name, trim($value));
        }

        return $value;
    }

    /**
     * Get or set a series of attributes (in the form of an array) into a DOMElement
     *
     * @param DOMElement $element    The element to insert the attributes
     * @param array      $value      The array of attributes.
     *                               The key is the name of the attribute.
     *
     * @return array
     * @throws Exception
     */
    public function attrs($element, $value = array())
    {
        if (empty($value)) {
            // Get current attributes
            $attrs = array();
            foreach ($element->attributes as $attr) {
                $attrs[$attr->name] = $attr->value;
            }

            // Return the current attributes
            return $attrs;
        } elseif (is_array($value) && count($value) > 0) {
            // Set the given attributes
            foreach ($value as $key => $val) {
                $this->attr($element, $key, $val);
            }
        }

        return array();
    }


    /**
     * Append a value into an attribute with a space between.
     *
     * @param DOMElement $element The element to append the attribute of.
     * @param string     $name    The name of the attribute
     * @param string     $value   The value to be appended.
     *
     * @return string The new attribute value.
     * @throws InvalidArgumentException
     */
    public function appendAttr($element, $name, $value)
    {
        // Check if the given element is valid
        if (empty($element)) {
            throw new InvalidArgumentException("You are trying to append an attribute to an empty element or the value is empty.");
        }

        // Create new attribute value
        $value = trim($value);
        $old_value = $element->getAttribute($name);
        $value = trim(trim($old_value) . " " . $value);

        // Set new attribute value
        return $this->attr($element, $name, $value);
    }


    /**
     * Inserts a data-[name] attribute into the given DOMNode.
     * It supports single value or an array of values.
     *
     * @param DOMElement $element The element to insert the attribute.
     * @param string     $name    The data name of the attribute (data-[name])
     * @param mixed      $value   The data value.
     *                            It can be a single value or an array of values.
     *
     * @return bool|string TRUE or the new value on success, FALSE on failure.
     * @throws InvalidArgumentException
     */
    public function data($element, $name, $value = array())
    {
        // Check if the given element is valid
        if (empty($element)) {
            throw new \InvalidArgumentException("You are trying to append an attribute to an empty element or the value is empty.");
        }

        // Check if value is empty
        if (empty($value)) {
            return false;
        }

        // Set normal data attribute
        if (!is_array($value)) {
            return $this->attr($element, 'data-' . $name, $value);
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

        return $this->attr($element, 'data-' . $name, $jsonValue);
    }


    /**
     * Appends a DOMElement to a parent DOMElement or to the DOMDocument
     *
     * @param DOMNode $parent    The parent that will receive the DOMElement.
     *                           If no child is given, this parent will be appended to DOMDocument.
     * @param DOMNode $child     The element to append to the parent.
     *
     * @return DOMNode The inserted DOMNode.
     * @throws InvalidArgumentException
     */
    public function append($parent, $child = null)
    {
        // Check if the given element is valid
        if (empty($parent)) {
            throw new \InvalidArgumentException("You are trying to append an element to an empty parent.");
        }

        // If child is empty, append element to document
        if (empty($child)) {
            return $this->appendChild($parent);
        }

        // Import Node to the current document
        $child = $this->importNode($child, true);

        // Insert the Node
        return $parent->appendChild($child);
    }


    /**
     * Prepends (appends first in the list) a DOMElement to a parent DOMElement
     *
     * @param DOMNode $parent The parent element
     * @param DOMNode $child  The child element.
     *
     * @return DOMNode The inserted DOMNode.
     * @throws InvalidArgumentException
     */
    public function prepend($parent, $child)
    {
        if (empty($child) || empty($parent)) {
            throw new InvalidArgumentException("prepend() takes no empty elements.");
        }

        // Append before first child
        if ($parent->childNodes->length > 0) {
            return $this->appendBefore($parent, $parent->childNodes->item(0), $child);
        }

        // There are no childs, append
        return $this->append($parent, $child);
    }

    /**
     * Appends a DOMElement to a parent DOMElement, before the given child.
     *
     * @param DOMNode $parent The parent element.
     * @param DOMNode $before The reference element before which the child will be appended.
     * @param DOMNode $child  The element that will be appended.
     *
     * @return DOMNode The inserted node.
     * @throws InvalidArgumentException
     */
    public function appendBefore($parent, $before, $child)
    {
        if (empty($child) || empty($parent) || empty($before)) {
            throw new \InvalidArgumentException("appendBefore() takes no empty elements.");
        }

        // Import and insert Node
        $child = $this->importNode($child, true);

        return $parent->insertBefore($child, $before);
    }

    /**
     * Replace a DOMElement with the new DOMElement.
     *
     * @param DOMNode $old The element to be replaced.
     * @param DOMNode $new The element to replace the old.
     *                     If Null, the old element will be removed.
     *
     * @return mixed The old node or FALSE if an error occurred.
     * @throws InvalidArgumentException
     */
    public function replace($old, $new)
    {
        // Check if given element is not empty
        if (empty($old)) {
            throw new InvalidArgumentException("You are trying to replace an empty element.");
        }

        // Remove or Remove
        if (empty($new)) {
            return $this->remove($old);
        }

        // Replace child
        return $old->parentNode->replaceChild($new, $old);
    }

    /**
     * Remove a DOMElement from the document.
     *
     * @param DOMNode $element The DOMElement to be removed.
     *
     * @return mixed If the child could be removed the function returns the old child.
     * @throws InvalidArgumentException
     */
    public function remove($element)
    {
        // Check if given element is not empty
        if (empty($element)) {
            throw new InvalidArgumentException("You are trying to replace an empty element.");
        }

        // Remove or Remove
        return $element->parentNode->removeChild($element);
    }

    /**
     * Sets or gets the nodeValue of the given DOMElement.
     * Returns the old value or the DOMElement if value is set.
     *
     * @param DOMNode $element The element to get its value.
     * @param string  $value   The value to be set.
     *                         If empty, the element's value will be returned.
     *
     * @return string The node value (old or new).
     * @throws InvalidArgumentException
     */
    public function nodeValue($element, $value = null)
    {
        // Check if given element is not empty
        if (empty($element)) {
            throw new InvalidArgumentException("You are trying to set a value to an empty element.");
        }

        // If given value is null, return the current value
        if (is_null($value)) {
            return $element->nodeValue;
        }

        // Return the new value
        return $element->nodeValue = $value;
    }

    /**
     * Get or Set inner HTML.
     * Returns the inner html of the element if no content is given.
     * Sets the innerHTML of an element elsewhere.
     *
     * @param DOMElement $element         The reference element.
     * @param string     $value           The html value to be set.
     *                                    If empty, it returns the innerHTML of the element.
     * @param boolean    $faultTolerant   Indicates whenever innerHTML will try to fix (well format html) the inserted
     *                                    string value.
     * @param boolean    $convertEncoding Option to convert the encoding of the value to UTF-8.
     *                                    It is TRUE by default.
     *
     * @return mixed Returns the innerHTML of the element if $value is NULL
     *               Otherwise sets the innerHTML of an element returning FALSE in case of error.
     * @throws InvalidArgumentException
     */
    public function innerHTML($element, $value = null, $faultTolerant = true, $convertEncoding = true)
    {
        // Check if given element is not empty
        if (empty($element)) {
            throw new InvalidArgumentException("You are trying to get or set inner html to an empty element.");
        }

        // If value is null, return inner HTML
        if (is_null($value) && !empty($element)) {
            $inner = "";
            foreach ($element->childNodes as $child) {
                $inner .= $this->saveXML($child);
            }

            return $inner;
        }

        // If value not null, set inner HTML

        // Empty the element
        for ($x = $element->childNodes->length - 1; $x >= 0; $x--) {
            $element->removeChild($element->childNodes->item($x));
        }

        // $value holds our new inner HTML
        if (empty($value == "")) {
            return false;
        }

        $f = $this->createDocumentFragment();
        // appendXML() expects well-formed markup (XHTML)
        $result = @$f->appendXML($value);

        if ($result) {
            if ($f->hasChildNodes()) {
                $element->appendChild($f);
            }
        } else {
            //$f = $element->ownerDocument;
            $f = new \DOMDocument("1.0", "UTF-8");

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
                    $importedNode = $this->importNode($child, true);
                    $this->append($element, $importedNode);
                }
            } else {    // Could not fix ill-html or we don't want to.
                return true;
            }
        }

        return true;
    }

    /**
     * Evaluate an XPath Query on the document
     *
     * @param string     $query   The XPath query to be evaluated
     * @param DOMElement $context The optional contextnode can be specified for doing relative XPath queries.
     *                            By default, the queries are relative to the root element.
     *                            It is NULL by default.
     *
     * @return mixed Returns a typed result if possible or a DOMNodeList containing all nodes matching the given XPath
     *               expression. If the expression is malformed or the contextnode is invalid, DOMXPath::evaluate()
     *               returns FALSE.
     * @throws InvalidArgumentException
     */
    public function evaluate($query, $context = null)
    {
        $xpath = new DOMXPath($this);
        $result = $xpath->evaluate($query, $context);
        if ($result === false)
            throw new InvalidArgumentException("The expression is malformed or the contextnode is invalid.");

        return $result;
    }

    /**
     * Find an element by id (using the evaluate function).
     *
     * @param string $id       The id of the element
     * @param string $nodeName The node name of the element. If not set, it searches for all nodes (*).
     *
     * @return mixed Returns the DOMElement or NULL if it doesn't exist.
     */
    public function find($id, $nodeName = "*")
    {
        $nodeName = (empty($nodeName) ? "*" : $nodeName);
        $q = "//" . $nodeName . "[@id='$id']";
        $list = self::evaluate($q);

        if ($list->length > 0)
            return $list->item(0);

        return null;
    }

    /**
     * Create an html comment and returns the element.
     *
     * @param string $content The comment content.
     *
     * @return DOMNode The comment node.
     */
    public function comment($content)
    {
        return $this->createComment($content);
    }

    /**
     * Returns the HTML form of the document.
     *
     * @param boolean $format Indicates whether to format the output.
     *
     * @return string The html generated by this document.,
     */
    public function getHTML($format = false)
    {
        $this->formatOutput = $format;

        return $this->saveHTML();
    }

    /**
     * Returns the XML form of the document
     *
     * @param boolean $format Indicates whether to format the output.
     *
     * @return string The xml generated by this document.
     */
    public function getXML($format = false)
    {
        $this->formatOutput = $format;

        return $this->saveXML();
    }
}

?>