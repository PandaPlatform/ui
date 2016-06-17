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

namespace Panda\Ui\Html\Frames;

use Panda\Ui\Contracts\DOMBuilder;
use Panda\Ui\DOMItem;
use Panda\Ui\Html\HTMLDocument;
use Panda\Ui\Html\HTMLElement;
use Panda\Ui\Html\Popups\Popup;

/**
 * Window Frame Prototype
 * It's the window frame prototype for building frames (windows, dialogs etc.).
 *
 * @package Panda\Ui\Html\Frames
 *
 * @version 0.1
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
     * @param string         $id
     * @param string         $class
     * @param string|DOMItem $title The frame's title.
     *
     * @return $this
     */
    public function build($id = '', $class = '', $title = '')
    {
        // Set basic properties
        $this->type(Popup::TP_PERSISTENT, false);
        $this->binding('on');

        // Create wFrame
        $id = 'wf_' . (empty($id) ? mt_rand() : $id);
        $this->wFrame = $this->getHTMLDocument()->getHTMLFactory()->buildElement('div', '', $id, 'wFrame');
        $this->wFrame->addClass($class);

        // Build parent element
        parent::build($id, $this->wFrame);

        // Create header
        $frameHeader = $this->getHTMLDocument()->getHTMLFactory()->buildElement('div', '', '', 'frameHeader');
        $this->append($frameHeader);

        // Header Title
        $frameTitle = $this->getHTMLDocument()->getHTMLFactory()->buildElement('span', $title, '', 'frameTitle');
        $frameHeader->append($frameTitle);

        // Close button
        $closeBtn = $this->getHTMLDocument()->getHTMLFactory()->buildElement('span', '', '', 'closeBtn');
        $frameHeader->append($closeBtn);

        // Create body
        $this->body = $this->getHTMLDocument()->getHTMLFactory()->buildElement('div', '', '', 'frameBody');
        $this->appendToFrame($this->body);

        return $this;
    }

    /**
     * Appends an element to frame.
     *
     * @param DOMItem $element The element to be appended.
     *
     * @return $this
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
     */
    public function appendToBody($element)
    {
        $this->body->append($element);

        return $this;
    }
}