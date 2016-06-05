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

namespace Panda\Ui\Contracts;

use Panda\Ui\Controls\Form\FormButton;
use Panda\Ui\Controls\Form\FormElement;
use Panda\Ui\Controls\Form\FormLabel;
use Panda\Ui\Html\HTMLElement;

/**
 * Interface HTMLFormFactoryInterface
 *
 * @package Panda\Ui\Contracts
 */
interface HTMLFormFactoryInterface extends HTMLFactoryInterface
{
    /**
     * Build an html form input.
     *
     * @param string $type
     * @param string $name
     * @param string $value
     * @param string $id
     * @param string $class
     * @param bool   $autofocus
     * @param bool   $required
     *
     * @return HTMLElement
     */
    public function buildInput($type = "text", $name = "", $value = "", $id = "", $class = "", $autofocus = false, $required = false);

    /**
     * Build an html form file input.
     *
     * @param string $name
     * @param string $id
     * @param string $class
     * @param bool   $required
     * @param string $accept
     *
     * @return HTMLElement
     */
    public function buildFileInput($name = "", $id = "", $class = "", $required = false, $accept = "");

    /**
     * Build an html form label.
     *
     * @param string $content
     * @param string $for
     * @param string $class
     *
     * @return FormLabel
     */
    public function buildLabel($content, $for = "", $class = "");

    /**
     * Build an html form button.
     *
     * @param string $type
     * @param string $title
     * @param string $name
     * @param string $id
     * @param string $class
     *
     * @return FormButton
     */
    public function buildButton($type, $title, $name = "", $id = "", $class = "");

    /**
     * Build an html form submit button.
     *
     * @param string $title
     * @param string $name
     * @param string $id
     * @param string $class
     *
     * @return FormButton
     */
    public function buildSubmitButton($title, $name = "", $id = "", $class = "");

    /**
     * Build an html form reset button.
     *
     * @param string $title
     * @param string $id
     * @param string $class
     *
     * @return FormButton
     */
    public function buildResetButton($title, $id = "", $class = "");

    /**
     * Build an html form textarea.
     *
     * @param string $name
     * @param string $value
     * @param string $id
     * @param string $class
     * @param bool   $autofocus
     * @param bool   $required
     *
     * @return FormElement
     */
    public function buildTextarea($name = "", $value = "", $id = "", $class = "", $autofocus = false, $required = false);

    /**
     * Build an html form fieldset.
     *
     * @param string $title
     * @param string $name
     * @param string $id
     * @param string $class
     *
     * @return FormElement
     */
    public function buildFieldset($title, $name = "", $id = "", $class = "");

    /**
     * Build an html form select element.
     *
     * @param string $name
     * @param bool   $multiple
     * @param string $id
     * @param string $class
     * @param array  $options
     * @param string $selectedValue
     * @param bool   $required
     *
     * @return mixed
     */
    public function buildSelect($name = "", $multiple = false, $id = "", $class = "", $options = array(), $selectedValue = "", $required = false);
}

?>