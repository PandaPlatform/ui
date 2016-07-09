<?php

/*
 * This file is part of the Panda framework Ui component.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Panda\Ui\Html\Views;

use InvalidArgumentException;
use Panda\Ui\Contracts\DOMBuilder;
use Panda\Ui\Html\HTMLDocument;
use Panda\Ui\Html\HTMLElement;

/**
 * Class ViewElement
 * Creates an HTMLElement loading an external html view.
 *
 * @package Panda\Ui\Html\Views
 *
 * @version 0.1
 */
class ViewElement extends HTMLElement implements DOMBuilder
{
    /**
     * Create a new View Element.
     *
     * @param HTMLDocument $HTMLDocument
     */
    public function __construct(HTMLDocument $HTMLDocument)
    {
        // Create DOMItem
        parent::__construct($HTMLDocument, $name = 'div', $value = '', $id = '', $class = '');
    }

    /**
     * Build the element.
     *
     * @param string $view
     * @param string $id
     * @param string $class
     *
     * @return $this
     */
    public function build($view = '', $id = '', $class = '')
    {
        // Load external view file
        if (!empty($view)) {
            $this->loadView($view);
        }

        // Set attributes
        $this->attr('id', $id);
        $this->addClass($class);

        return $this;
    }

    /**
     * Load external html view into the html element.
     * It clears the inner html of the element first.
     *
     * @param string $view
     *
     * @return $this
     *
     * @throws InvalidArgumentException
     */
    public function loadView($view)
    {
        // Check for view name
        if (empty($view)) {
            throw new InvalidArgumentException('View file cannot be empty.');
        }

        // Check if the file exists
        if (!file_exists($view)) {
            throw new InvalidArgumentException('View file cannot be found.');
        }

        // Load view file
        $viewHTML = file_get_contents($view);
        $viewHTML = trim($viewHTML);
        if (!empty($viewHTML)) {
            $this->innerHTML($viewHTML);
        }

        return $this;
    }

    /**
     * Get the full html of the current view.
     *
     * @return string
     */
    public function getHTML()
    {
        return $this->outerHTML();
    }
}
