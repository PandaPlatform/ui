<?php

/*
 * This file is part of the Panda UI Package.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Panda\Ui\Html\Views;

use InvalidArgumentException;
use Panda\Ui\Html\HTMLPage;

/**
 * Class ViewPage
 * Creates an HTMLPage and appends the current view inside the body.
 *
 * @package Panda\Ui\Views
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
     * @throws InvalidArgumentException
     */
    public function addView($view, $name, $value = '', $id = '', $class = '')
    {
        // Create the view element
        $this->view = new ViewElement($this, $view, $name, $value, $id, $class);

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
