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
use DOMElement;
use DOMNodeList;
use DOMXPath;
use InvalidArgumentException;
use Panda\Ui\Contracts\DOMFactoryInterface;

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
     * @type DOMFactoryInterface
     */
    protected $DOMFactory;

    /**
     * Create a new DOM Document.
     *
     * @param DOMFactoryInterface $DOMFactory
     * @param string              $version
     * @param string              $encoding
     */
    public function __construct(DOMFactoryInterface $DOMFactory, $version = "1.0", $encoding = "UTF_8")
    {
        // Construct DOMDocument
        parent::__construct($version, $encoding);

        // Set DOMFactory
        $this->DOMFactory = $DOMFactory;
        $this->DOMFactory->setDocument($this);
    }

    /**
     * Creates and returns a DOMElement with the specified tagName and the given attributes
     *
     * @param string $name  The tag of the element.
     * @param mixed  $value The content of the element. It can be a string or a DOMElement.
     *
     * @return DOMItem The DOMItem created
     */
    public function create($name = "div", $value = "")
    {
        // Create a new DOMItem
        return (new DOMItem($this, $name, $value));
    }

    /**
     * Append a DOM Item element to the document.
     *
     * @param DOMItem $element
     *
     * @return DOMPrototype
     */
    public function append($element)
    {
        // Check element
        if (empty($element)) {
            throw new InvalidArgumentException("You are trying to append an empty element.");
        }
        // Import element to the document
        $element = $this->importNode($element->getDOMElement(), true);

        // Append element
        $this->appendChild($element);

        // Return the DOMPrototype
        return $this;
    }

    /**
     * Evaluate an XPath Query on the document
     *
     * @param string     $query   The XPath query to be evaluated
     * @param DOMElement $context The optional contextnode can be specified for doing relative XPath queries.
     *                            By default, the queries are relative to the root element.
     *                            It is NULL by default.
     *
     * @return DOMNodeList Returns a typed result if possible or a DOMNodeList containing all nodes matching the given
     *                     XPath expression. If the expression is malformed or the contextnode is invalid,
     *                     DOMXPath::evaluate() returns False.
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

    /**
     * @return DOMFactoryInterface
     */
    public function getDOMFactory()
    {
        return $this->DOMFactory;
    }

    /**
     * @param DOMFactoryInterface $DOMFactory
     */
    public function setDOMFactory($DOMFactory)
    {
        $this->DOMFactory = $DOMFactory;
    }
}

?>