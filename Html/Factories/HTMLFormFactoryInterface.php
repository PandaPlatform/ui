<?php

/*
 * This file is part of the Panda Ui Package.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Panda\Ui\Html\Factories;

use Panda\Ui\Html\Controls\Form;
use Panda\Ui\Html\Controls\Form\FormElement;

/**
 * Interface HTMLFormFactoryInterface
 * @package Panda\Ui\Html\Factories
 */
interface HTMLFormFactoryInterface extends HTMLFactoryInterface
{
    /**
     * Build a form control.
     *
     * @param string $id
     * @param string $action
     * @param bool   $async
     * @param bool   $fileUpload
     *
     * @return Form
     */
    public function buildForm($id = '', $action = '', $async = false, $fileUpload = false);

    /**
     * Build an html form element.
     *
     * @param string $itemName
     * @param string $name
     * @param string $value
     * @param string $id
     * @param string $class
     * @param string $itemValue
     *
     * @return FormElement
     */
    public function buildFormElement($itemName = '', $name = '', $value = '', $id = '', $class = '', $itemValue = '');

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
     * @return FormElement
     */
    public function buildInput($type = 'text', $name = '', $value = '', $id = '', $class = '', $autofocus = false, $required = false);

    /**
     * Build an html form file input.
     *
     * @param string $name
     * @param string $id
     * @param string $class
     * @param bool   $required
     * @param string $accept
     *
     * @return FormElement
     */
    public function buildFileInput($name = '', $id = '', $class = '', $required = false, $accept = '');

    /**
     * Build an html form label.
     *
     * @param string $content
     * @param string $for
     * @param string $class
     *
     * @return FormElement
     */
    public function buildLabel($content, $for = '', $class = '');

    /**
     * Build an html form button.
     *
     * @param string $type
     * @param string $title
     * @param string $name
     * @param string $id
     * @param string $class
     *
     * @return FormElement
     */
    public function buildButton($type, $title, $name = '', $id = '', $class = '');

    /**
     * Build an html form submit button.
     *
     * @param string $title
     * @param string $name
     * @param string $id
     * @param string $class
     *
     * @return FormElement
     */
    public function buildSubmitButton($title, $name = '', $id = '', $class = '');

    /**
     * Build an html form reset button.
     *
     * @param string $title
     * @param string $id
     * @param string $class
     *
     * @return FormElement
     */
    public function buildResetButton($title, $id = '', $class = '');

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
    public function buildTextarea($name = '', $value = '', $id = '', $class = '', $autofocus = false, $required = false);

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
    public function buildFieldset($title, $name = '', $id = '', $class = '');

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
     * @return FormElement
     */
    public function buildSelect($name = '', $multiple = false, $id = '', $class = '', $options = [], $selectedValue = '', $required = false);
}
