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
use Panda\Ui\Html\HTMLElement;

/**
 * Window Frame Prototype
 * It's the window frame prototype for building frames (windows, dialogs etc.).
 *
 * @package Panda\Ui\Frames
 *
 * @version 0.1
 */
class WindowFrame extends HTMLElement implements DOMBuilder
{
    /**
     * The frame's body container.
     *
     * @var HTMLElement
     */
    private $body;

    /**
     * Create a new frame instance.
     *
     * @param string $id
     * @param string $class
     */
    public function __construct($id = '', $class = '')
    {
        $id = (empty($id) ? 'wf' . mt_rand() : $id);
        parent::__construct($name = 'div', $value = '', $id, $class = 'wFrame');
        $this->addClass($class);
    }

    /**
     * Builds the window frame structure.
     *
     * @param mixed  $title The frame's title.
     *                      It can be string or DOMElement.
     * @param string $class The frame's class.
     *
     * @return $this
     */
    public function build($title = '', $class = '')
    {
        // Add class
        $this->addClass($class);

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
        $this->append($this->body);

        return $this;
    }

    /**
     * Appends an element to frame body.
     *
     * @param HTMLElement $element The element to be appended.
     *
     * @return $this
     */
    public function appendToBody($element)
    {
        $this->body->append($element);

        return $this;
    }
}