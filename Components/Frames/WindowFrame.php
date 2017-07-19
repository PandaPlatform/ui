<?php

/*
 * This file is part of the Panda Ui Package.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Panda\Ui\Components\Frames;

use DOMElement;
use Exception;
use InvalidArgumentException;
use Panda\Ui\Components\Popups\Popup;
use Panda\Ui\Dom\DOMBuilder;
use Panda\Ui\Dom\DOMItem;
use Panda\Ui\Html\HTMLElement;

/**
 * Window Frame Prototype
 * It's the window frame prototype for building frames (windows, dialogs etc.).
 *
 * @package Panda\Ui\Html\Frames
 */
class WindowFrame extends Popup implements DOMBuilder
{
    /**
     * The frame HTML Element.
     *
     * @var HTMLElement
     */
    protected $wFrame;

    /**
     * The frame's body container.
     *
     * @var HTMLElement
     */
    protected $body;

    /**
     * Builds the window frame structure.
     *
     * @param string           $id
     * @param string           $class
     * @param DOMElement|mixed $content
     * @param string|DOMItem   $title The frame's title.
     *
     * @return $this
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function build($id = '', $class = '', $content = null, $title = 'Window Frame')
    {
        // Set basic properties
        $this->type(Popup::TP_PERSISTENT, false);
        $this->binding('on');

        // Create wFrame
        $id = 'wf_' . (empty($id) ? mt_rand() : $id);
        $this->wFrame = $this->getHTMLDocument()->getHTMLFactory()->buildHtmlElement('div', '', $id, 'window-frame');
        $this->wFrame->addClass($class);

        // Build parent element and append content to frame
        parent::build($id, $this->wFrame);

        // Create header
        $frameHeader = $this->getHTMLDocument()->getHTMLFactory()->buildHtmlElement('div', '', '', 'frame-header');
        $this->appendToFrame($frameHeader);

        // Header Title
        $frameTitle = $this->getHTMLDocument()->getHTMLFactory()->buildHtmlElement('span', $title, '', 'frame-title');
        $frameHeader->append($frameTitle);

        // Close button
        $closeBtn = $this->getHTMLDocument()->getHTMLFactory()->buildHtmlElement('span', '', '', 'button-close');
        $frameHeader->append($closeBtn);

        // Create body
        $this->body = $this->getHTMLDocument()->getHTMLFactory()->buildHtmlElement('div', '', '', 'frame-body');
        $this->appendToFrame($this->body);

        // Append given content to frame body, if any
        $this->appendToBody($content);

        return $this;
    }

    /**
     * Appends an element to frame.
     *
     * @param DOMItem $element The element to be appended.
     *
     * @return $this
     * @throws InvalidArgumentException
     */
    public function appendToFrame($element)
    {
        $this->wFrame->append($element);

        return $this;
    }

    /**
     * Appends an element to frame body.
     *
     * @param DOMItem $element The element to be appended.
     *
     * @return $this
     * @throws InvalidArgumentException
     */
    public function appendToBody($element)
    {
        $this->body->append($element);

        return $this;
    }
}
