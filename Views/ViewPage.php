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

use Panda\Ui\Html\HTMLPage;

/**
 * Class ViewPage
 * Creates an HTMLPage and appends the current view inside the body.
 *
 * @package Panda\Ui\Views
 * @version 0.1
 */
class ViewPage extends HTMLPage
{
    /**
     * @var ViewElement
     */
    protected $view;

    /**
     * Add the view to the page.
     *
     * @param string $view
     * @param string $name
     * @param string $value
     * @param string $id
     * @param string $class
     *
     * @return $this
     */
    public function addView($view, $name, $value = '', $id = '', $class = '')
    {
        // Create the view element
        $this->view = new ViewElement($view, $name, $value, $id, $class);

        // Append to body and return object
        return $this->appendToBody($this->view);
    }

    /**
     * @return ViewElement
     */
    public function getView()
    {
        return $this->view;
    }
}

