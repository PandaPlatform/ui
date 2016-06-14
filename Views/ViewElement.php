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

namespace Panda\Ui\Views;

use Exception;
use InvalidArgumentException;
use Panda\Ui\DOMPrototype;
use Panda\Ui\Html\HTMLElement;

/**
 * Class ViewElement
 * Creates an HTMLElement loading an external html view.
 *
 * @package Panda\Ui\Views
 * @version 0.1
 */
class ViewElement extends HTMLElement
{
    /**
     * Create a new HTMLObject.
     *
     * @param DOMPrototype $HTMLDocument The DOMDocument to create the element
     * @param string       $view         The external html view file.
     * @param string       $name         The elemenet name.
     * @param string       $value        The element value.
     *                                   It can be text or another HTMLElement.
     * @param string       $id           The element id attribute value.
     * @param string       $class        The element class attribute value.
     *
     * @throws Exception
     */
    public function __construct($HTMLDocument, $view = '', $name = 'div', $value = '', $id = '', $class = '')
    {
        // Create DOMItem
        parent::__construct($HTMLDocument, $name, $value, $id, $class);

        // Load external view file
        if (!empty($view)) {
            $this->loadView($view);
        }
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

