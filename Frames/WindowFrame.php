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

namespace Panda\Ui\Frames;

use Panda\Ui\Contracts\DOMBuilder;
use Panda\Ui\DOMItem;
use Panda\Ui\Html\HTMLElement;
use Panda\Ui\Popups\Popup;

/**
 * Window Frame Prototype
 * It's the window frame prototype for building frames (windows, dialogs etc.).
 *
 * @package Panda\Ui\Frames
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
     * Create a new frame popup instance.
     *
     * @param string $id
     * @param string $class
     */
    public function __construct($id = '', $class = '')
    {
        // Create popup
        parent::__construct($id);

        // Set basic properties
        $this->type(Popup::TP_PERSISTENT, false);
        $this->binding('on');

        // Create wFrame
        $id = 'wf_' . (empty($id) ? mt_rand() : $id);
        $this->wFrame = new HTMLElement('div', '', $id, 'wFrame');
        $this->wFrame->addClass($class);
    }

    /**
     * Builds the window frame structure.
     *
     * @param string|DOMItem $title The frame's title.
     *
     * @return $this
     */
    public function build($title = '')
    {
        // Create header
        $frameHeader = new HTMLElement('div', '', '', 'frameHeader');
        $this->append($frameHeader);

        // Header Title
        $frameTitle = new HTMLElement('span', $title, '', 'frameTitle');
        $frameHeader->append($frameTitle);

        // Close button
        $closeBtn = new HTMLElement('span', '', '', 'closeBtn');
        $frameHeader->append($closeBtn);

        // Create body
        $this->body = new HTMLElement('div', '', '', 'frameBody');
        $this->appendToFrame($this->body);

        return parent::build($this->wFrame);
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