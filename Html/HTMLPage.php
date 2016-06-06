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
use InvalidArgumentException;
use Panda\Ui\Contracts\DOMBuilder;
use Panda\Ui\Contracts\Factories\HTMLFactoryInterface;
use Panda\Ui\Factories\HTMLFactory;

/**
 * HTML Page Prototype/Builder
 * Helps building HTML Pages in HTML5 format
 *
 * @package Panda\Ui\Html
 * @version 0.1
 */
class HTMLPage extends HTMLDocument implements DOMBuilder
{
    /**
     * The head tag object
     *
     * @type HTMLElement
     */
    protected $HTMLHead;

    /**
     * The body tag object
     *
     * @type HTMLElement
     */
    protected $HTMLBody;

    /**
     * Keeps the scripts to be inserted in the bottom of the page before exporting,
     *
     * @type array
     */
    private $bottomScripts;

    /**
     * HTMLPage constructor.
     *
     * @param HTMLFactoryInterface|null $HTMLFactory
     */
    public function __construct($HTMLFactory = null)
    {
        // Initialize-Clear Bottom Scripts
        $this->bottomScripts = array();
        $HTMLFactory = $HTMLFactory ?: new HTMLFactory();
        $HTMLFactory->setDocument($this);

        // Call parent
        parent::__construct($HTMLFactory);
    }

    /**
     * Builds the spine of the page.
     *
     * @param string $title       The title tag of the page.
     *                            It is a required field for the document to be valid.
     * @param string $description The description meta value.
     * @param string $keywords    The keywords meta value.
     *
     * @return $this
     */
    public function build($title = "", $description = "", $keywords = "")
    {
        // Build HTML
        $HTML = $this->create("html");
        $this->append($HTML);

        // Build HEAD
        $this->HTMLHead = $this->create('head');
        $HTML->append($this->HTMLHead);

        // Setup head elements
        $this->setupHead($title, $description, $keywords);

        // Build BODY
        $this->HTMLBody = $this->create('body');
        $HTML->append($this->HTMLBody);

        return $this;
    }

    /**
     * Returns the entire HTML page in HTML5 format.
     *
     * @return string The html output.
     */
    public function getHTML()
    {
        // Insert Bottom Scripts (if any)
        $this->flushBottomScripts();

        // Return text/html
        return "<!DOCTYPE html>\n" . parent::getHTML();
    }

    /**
     * Returns the head tag object.
     *
     * @return DOMElement The head element.
     */
    public function getHead()
    {
        return $this->HTMLHead->getDOMElement();
    }

    /**
     * Returns the body tag object.
     *
     * @return DOMElement The body element.
     */
    public function getBody()
    {
        return $this->HTMLBody->getDOMElement();
    }

    /**
     * Append element to head.
     *
     * @param HTMLElement $element The element to be appended.
     *
     * @return $this
     * @throws InvalidArgumentException
     */
    protected function appendToHead($element)
    {
        // Check if the element is valid
        if (empty($element)) {
            throw new InvalidArgumentException("The element provided is empty.");
        }

        // Append element to head
        $this->HTMLHead->append($element);

        return $this;
    }

    /**
     * Append element to body.
     *
     * @param HTMLElement $element The element to be appended.
     *
     * @return $this
     * @throws InvalidArgumentException
     */
    protected function appendToBody($element)
    {
        // Check if the element is valid
        if (empty($element)) {
            throw new InvalidArgumentException("The element provided is empty.");
        }

        // Append element to body
        $this->HTMLBody->append($element);

        return $this;
    }

    /**
     * Add a meta element to head.
     *
     * @param string $name      The meta name attribute.
     * @param string $content   The meta content attribute.
     * @param string $httpEquiv The meta http-equiv attribute.
     * @param string $charset   The meta charset attribute.
     *
     * @return HTMLElement The meta element.
     */
    protected function addMeta($name = "", $content = "", $httpEquiv = "", $charset = "")
    {
        // Create meta element
        $meta = $this->getHTMLFactory()->buildMeta($name, $content, $httpEquiv, $charset);

        // Append meta to head
        $this->appendToHead($meta);

        // Return meta element
        return $meta;
    }

    /**
     * Inserts a css line.
     *
     * @param string $href The href attribute of the link
     *
     * @return HTMLElement The style element created.
     */
    public function addStyle($href)
    {
        // Get css link
        $css = $this->getHTMLFactory()->buildLink("stylesheet", $href);

        // Append link to head
        $this->appendToHead($css);

        // Return the html element
        return $css;
    }

    /**
     * Inserts a script line.
     *
     * @param string  $src    The URL source file of the script.
     * @param boolean $async  Set the async attribute to script tag.
     *                        It is FALSE by default.
     * @param boolean $bottom Indicator whether the script tag will be placed at the bottom of the page.
     *                        The default value is FALSE.
     *
     * @return HTMLElement The script element created.
     */
    public function addScript($src, $async = false, $bottom = false)
    {
        // Build the script element
        $script = $this->getHTMLFactory()->buildScript($src, $async);

        // Choose to append to head or to bottom scripts
        if ($bottom) {
            $this->addToBottomScripts($script);
        } else {
            $this->appendToHead($script);
        }

        // Return the script element
        return $script;
    }

    /**
     * Inserts a page icon.
     * It covers both "icon" and "shortcut icon".
     *
     * @param string $href The icon URL
     *
     * @return $this
     */
    public function addIcon($href)
    {
        // Build the normal icon
        $icon = $this->getHTMLFactory()->buildLink("icon", $href);
        $this->appendToHead($icon);

        // Build the shortcut icon
        $shortIcon = $this->getHTMLFactory()->buildLink("shortcut icon", $href);
        $this->appendToHead($shortIcon);

        return $this;
    }

    /**
     * Sets the page title.
     *
     * @param string $title The new page title.
     *
     * @return $this
     */
    public function setTitle($title)
    {
        // Check if title already exists
        $headTitle = $this->select("title")->item(0);
        if (!is_null($headTitle)) {
            $headTitle_new = $this->create("title", $title);
            $headTitle->parentNode->replaceChild($headTitle_new->getDOMElement(), $headTitle);
        } else {
            $headTitle = $this->create("title", $title);
            $this->appendToHead($headTitle);
        }

        return $this;
    }

    /**
     * Add open graph meta properties to the page.
     *
     * @param array $data An array of property => content open graph meta.
     *                    The og: at the property name is inserted automatically.
     *
     * @return $this
     */
    public function addOpenGraphMeta($data = array())
    {
        foreach ($data as $property => $content) {
            // Create the open graph meta
            $og = $this->getHTMLFactory()->buildMeta($name = "", $content, $httpEquiv = "", $charset = "");
            $og->attr($og, "property", "og:" . $property);
            $og->attr($og, "content", $content);

            // Append meta to head
            $this->appendToHead($og);
        }

        return $this;
    }

    /**
     * Builds all the meta tags along with the document title tag.
     *
     * @param string $title       The title of the document.
     * @param string $description The description meta.
     * @param string $keywords    The keywords meta.
     *
     * @return $this
     */
    private function setupHead($title, $description, $keywords)
    {
        // Create title tag
        $this->setTitle($title);

        // Create meta tags
        $this->addMeta($name = "", $content = "", $httpEquiv = "", $charset = "UTF-8");
        if (!empty($description)) {
            $this->addMeta($name = "description", $description);
        }
        if (!empty($keywords)) {
            $this->addMeta($name = "keywords", $keywords);
        }

        return $this;
    }

    /**
     * Insert the given script tag to stack, in order to be inserted at the bottom of the page right before delivering
     * the page.
     *
     * @param HTMLElement $script The script tag element.
     */
    private function addToBottomScripts($script)
    {
        $this->bottomScripts[] = $script;
    }

    /**
     * Appends all bottom scripts to the body.
     *
     * @return    void
     */
    private function flushBottomScripts()
    {
        foreach ($this->bottomScripts as $script) {
            $this->appendToBody($script);
        }
    }

    /**
     * @return HTMLFactory
     */
    public function getHTMLFactory()
    {
        return $this->DOMFactory;
    }
}

?>