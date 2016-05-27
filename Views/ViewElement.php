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
    public function __construct(DOMPrototype $HTMLDocument, $view, $name, $value = "", $id = "", $class = "")
    {
        // Create DOMItem
        parent::__construct($HTMLDocument, $name, $value, $id, $class);

        // Load external view file
        $this->loadView($view);
    }

    /**
     * Load external html view into the html element.
     * It clears the inner html of the element first.
     *
     * @param string $view
     */
    public function loadView($view)
    {
        // Check if the file exists
        if (!file_exists($view)) {
            return;
        }

        // Load view file
        $viewHTML = include($view);
        $viewHTML = trim($viewHTML);
        if (!empty($viewHTML)) {
            $this->innerHTML($value = "");
            $this->innerHTML($viewHTML);
        }
    }
}

?>