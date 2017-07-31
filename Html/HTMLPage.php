<?php

/*
 * This file is part of the Panda Ui Package.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Panda\Ui\Html;

use Exception;
use InvalidArgumentException;
use Panda\Ui\Dom\DOMBuilder;
use Panda\Ui\Dom\Factories\DOMFactoryInterface;
use Panda\Ui\Html\Factories\HTMLFactoryInterface;

/**
 * Class HTMLPage
 * @package Panda\Ui\Html
 */
class HTMLPage extends HTMLDocument implements DOMBuilder
{
    /**
     * The head tag object
     *
     * @var HTMLElement
     */
    protected $head;

    /**
     * The body tag object
     *
     * @var HTMLElement
     */
    protected $body;

    /**
     * Keeps the scripts to be inserted in the bottom of the page before exporting,
     *
     * @var array
     */
    protected $bottomScripts = [];

    /**
     * Builds the spine of the page.
     *
     * @param string $title       The title tag of the page.
     *                            It is a required field for the document to be valid.
     * @param string $description The description meta value.
     * @param string $keywords    The keywords meta value.
     *
     * @return $this
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function build($title = '', $description = '', $keywords = '')
    {
        // Build html root element
        $html = $this->create('html');
        $this->append($html);

        // Build head
        $this->head = $this->create('head');
        $html->append($this->head);

        // Setup head elements
        $this->setupHead($title, $description, $keywords);

        // Build body
        $this->body = $this->create('body');
        $html->append($this->body);

        return $this;
    }

    /**
     * Returns the entire HTML page in HTML5 format.
     *
     * @param bool $format
     *
     * @return string
     * @throws InvalidArgumentException
     */
    public function getHTML($format = false)
    {
        // Insert Bottom Scripts (if any)
        $this->flushBottomScripts();

        // Return text/html
        return "<!DOCTYPE html>\n" . parent::getHTML($format);
    }

    /**
     * Append element to head.
     *
     * @param HTMLElement $element The element to be appended.
     *
     * @return $this
     * @throws InvalidArgumentException
     */
    public function appendToHead($element)
    {
        // Check if the element is valid
        if (empty($element)) {
            throw new InvalidArgumentException('The element provided is empty.');
        }

        // Append element to head
        $this->getHead()->append($element);

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
    public function appendToBody($element)
    {
        // Check if the element is valid
        if (empty($element)) {
            throw new InvalidArgumentException('The element provided is empty.');
        }

        // Append element to body
        $this->getBody()->append($element);

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
     * @return HTMLElement
     * @throws InvalidArgumentException
     */
    public function addMeta($name = '', $content = '', $httpEquiv = '', $charset = '')
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
     * @return HTMLElement
     * @throws InvalidArgumentException
     */
    public function addStyle($href)
    {
        // Get css link
        $css = $this->getHTMLFactory()->buildLink('stylesheet', $href);

        // Append link to head
        $this->appendToHead($css);

        // Return the html element
        return $css;
    }

    /**
     * Inserts a script line.
     *
     * @param string $src    The URL source file of the script.
     * @param bool   $async  Set the async attribute to script tag.
     *                       It is FALSE by default.
     * @param bool   $bottom Indicator whether the script tag will be placed at the bottom of the page.
     *                       The default value is FALSE.
     *
     * @return HTMLElement
     * @throws InvalidArgumentException
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
     * It covers both 'icon' and 'shortcut icon'.
     *
     * @param string $href The icon URL
     *
     * @return $this
     * @throws InvalidArgumentException
     */
    public function addIcon($href)
    {
        // Build the normal icon
        $icon = $this->getHTMLFactory()->buildLink('icon', $href);
        $this->appendToHead($icon);

        // Build the shortcut icon
        $shortIcon = $this->getHTMLFactory()->buildLink('shortcut icon', $href);
        $this->appendToHead($shortIcon);

        return $this;
    }

    /**
     * Sets the page title.
     *
     * @param string $title The new page title.
     *
     * @return $this
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function setTitle($title)
    {
        // Check if title already exists
        $headTitle = $this->select('title')->item(0);
        if (!is_null($headTitle)) {
            $headTitle_new = $this->create('title', $title);
            $headTitle->parentNode->replaceChild($headTitle_new, $headTitle);
        } else {
            $headTitle = $this->create('title', $title);
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
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function addOpenGraphMeta($data = [])
    {
        foreach ($data as $property => $content) {
            // Create the open graph meta
            $og = $this->getHTMLFactory()->buildMeta($name = '', $content, $httpEquiv = '', $charset = '');
            $og->attr('property', 'og:' . $property);

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
     * @throws Exception
     * @throws InvalidArgumentException
     */
    private function setupHead($title, $description, $keywords)
    {
        // Create title tag
        $this->setTitle($title);

        // Create meta tags
        $this->addMeta($name = '', $content = '', $httpEquiv = '', $charset = 'UTF-8');
        if (!empty($description)) {
            $this->addMeta($name = 'description', $description);
        }
        if (!empty($keywords)) {
            $this->addMeta($name = 'keywords', $keywords);
        }

        return $this;
    }

    /**
     * Insert the given script tag to stack, in order to be inserted at the bottom of the page right before delivering
     * the page.
     *
     * @param HTMLElement $script The script tag element.
     *
     * @return $this
     */
    private function addToBottomScripts($script)
    {
        $this->bottomScripts[] = $script;

        return $this;
    }

    /**
     * Appends all bottom scripts to the body.
     *
     * @return $this
     * @throws InvalidArgumentException
     */
    private function flushBottomScripts()
    {
        foreach ($this->bottomScripts as $script) {
            $this->appendToBody($script);
        }

        return $this;
    }

    /**
     * @return HTMLFactoryInterface|DOMFactoryInterface
     */
    public function getHTMLFactory()
    {
        return $this->DOMFactory;
    }

    /**
     * @return HTMLElement
     */
    public function getHead()
    {
        return $this->head;
    }

    /**
     * @return HTMLElement
     */
    public function getBody()
    {
        return $this->body;
    }
}
