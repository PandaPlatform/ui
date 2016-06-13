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

namespace Panda\Ui\Factories;

use Exception;
use Panda\Ui\Contracts\Factories\HTMLFormFactoryInterface;
use Panda\Ui\Controls\Form\FormButton;
use Panda\Ui\Controls\Form\FormElement;
use Panda\Ui\Controls\Form\FormInput;
use Panda\Ui\Controls\Form\FormLabel;
use Panda\Ui\Controls\Form\FormSelect;
use Panda\Ui\Html\HTMLElement;

/**
 * Class FormFactory
 *
 * @package Panda\Ui\Controls
 */
class FormFactory extends HTMLFactory implements HTMLFormFactoryInterface
{
    /**
     * Builds and returns an input item.
     *
     * @param string  $type      The input's type.
     *                           This must abide by the rules of the possible input types.
     * @param string  $name      The input's name.
     * @param string  $value     The input's default value.
     *                           It is empty by default.
     * @param string  $id        The input's id attribute.
     * @param string  $class     The extra class for the input.
     *                           It is empty by default.
     * @param bool $autofocus Inserts the autofocus attribute to the input.
     *                           It is FALSE by default.
     * @param bool $required  Indicates this input as required.
     *                           It is FALSE by default.
     *
     * @return HTMLElement The form input element
     * @throws Exception
     */
    public function buildInput($type = 'text', $name = '', $value = '', $id = '', $class = '', $autofocus = false, $required = false)
    {
        // Create form input
        $id = $id ?: 'fi' . mt_rand();
        $fi = new FormInput($this->getDocument(), $type, $name, $id, $class, $value, $required);

        // Add extra attributes
        $fi->attr('autofocus', $autofocus);

        // Return form item
        return $fi;
    }

    /**
     * Build an html form file input.
     *
     * @param string $name     The input's name.
     * @param string $id       The input's id attribute.
     * @param string $class    The extra class for the input.
     * @param bool   $required Indicates this input as required.
     *                         It is False by default.
     * @param string $accept   The accept attribute for the file dialog.
     *
     * @return HTMLElement The form file input element.
     * @throws Exception
     */
    public function buildFileInput($name = '', $id = '', $class = '', $required = false, $accept = '')
    {
        // Create file input
        $id = $id ?: 'ffi' . mt_rand();
        $fi = $this->buildInput($type = 'file', $name, $value = '', $id, $class, $autofocus = false, $required);

        // Set accept attribute
        $fi->attr('accept', $accept);

        // Return form item
        return $fi;
    }

    /**
     * Build an html form label.
     *
     * @param string $content The label content.
     * @param string $for     The input's id where this label is pointing to.
     * @param string $class   The extra class for the label.
     *
     * @return FormLabel The form label element
     */
    public function buildLabel($content, $for = '', $class = '')
    {
        // Create new form label
        $fl = new FormLabel($this->getDocument(), $content, $for);

        // Add class
        $fl->addClass($class);

        // Return form label
        return $fl;
    }

    /**
     * Built an html form button.
     *
     * @param string $type  The button's type
     * @param string $title The button's title
     * @param string $name  The button's name attribute
     * @param string $id    The button's id attribute.
     * @param string $class The extra class of the button
     *
     * @return FormButton The form button element
     */
    public function buildButton($type, $title, $name = '', $id = '', $class = '')
    {
        // Create new form button
        $id = $id ?: 'fb' . mt_rand();
        $fb = new FormButton($this->getDocument(), $type, $name, $id, $title);

        // Add class
        $fb->addClass($class);

        // Return form button
        return $fb;
    }

    /**
     * Built an html form submit button.
     *
     * @param string $title The button's title
     * @param string $name  The button's name attribute
     * @param string $id    The button's id attribute
     * @param string $class The extra class of the button
     *
     * @return FormButton The submit button.
     * @throws Exception
     */
    public function buildSubmitButton($title, $name = '', $id = '', $class = '')
    {
        // Create the form submit button
        $id = $id ?: 'fsb' . mt_rand();

        return $this->buildButton($type = 'submit', $title, $name, $id, $class);
    }

    /**
     * Built an html form reset button.
     *
     * @param string $title The button's title
     * @param string $id    The button's id attribute
     * @param string $class The extra class of the button
     *
     * @return FormButton The reset button
     * @throws Exception
     */
    public function buildResetButton($title, $id = '', $class = '')
    {
        // Create the form reset button
        $id = $id ?: 'frb' . mt_rand();

        return $this->buildButton($type = 'reset', $title, $name = '', $id, $class);
    }

    /**
     * Build an html form textarea.
     *
     * @param string $name      The textarea's name.
     * @param string $value     The textarea's default value.
     * @param string $id        The textarea's id attribute
     * @param string $class     The extra class for the textarea.
     * @param bool   $autofocus Inserts the autofocus attribute to the input.
     * @param bool   $required  Indicates this textarea as required.
     *
     * @return FormElement The html form textarea.
     * @throws Exception
     */
    public function buildTextarea($name = '', $value = '', $id = '', $class = '', $autofocus = false, $required = false)
    {
        // Create Form Item
        $id = $id ?: 'ftxt' . mt_rand();
        $fi = new FormElement($this->getDocument(), $itemName = 'textarea', $name, $id, $value, $class, $itemValue = '');
        $fi->nodeValue($value);

        // Set attributes
        $fi->attr('autofocus', $autofocus);
        $fi->attr('required', $required);

        // Return form item
        return $fi;
    }

    /**
     * Build an html form fieldset element.
     *
     * @param string $title The fieldset's legend title.
     * @param string $name  The fieldset's name.
     * @param string $id    The fieldset's id.
     * @param string $class The fieldset's class.
     *
     * @return FormElement The fieldset form element.
     */
    public function buildFieldset($title, $name = '', $id = '', $class = '')
    {
        // Create fieldset item
        $id = $id ?: 'flds' . mt_rand();
        $fi = new FormElement($this->getDocument(), $itemName = 'fieldset', $name, $value = '', $id, $class, $itemValue = '');

        // Create and append legend
        $legend = $this->getDocument()->getHTMLFactory()->buildElement('legend', $title);
        $fi->append($legend);

        // Return the fieldset element
        return $fi;
    }

    /**
     * Build an html form select element.
     *
     * @param string $name          The select's name.
     * @param bool   $multiple      Option for multiple selection.
     * @param string $id            The select's id attribute.
     * @param string $class         The select's class attribute.
     * @param array  $options       An array of value -> title options for the select element.
     * @param string $selectedValue The select's selected value among options.
     * @param bool   $required      Sets the input as required for the form.
     *
     * @return FormElement The select form element.
     */
    public function buildSelect($name = '', $multiple = false, $id = '', $class = '', $options = [], $selectedValue = '', $required = false)
    {
        // Create select form input
        $id = $id ?: 'fs' . mt_rand();
        $fi = new FormSelect($this->getDocument(), $name, $id, $class, $multiple, $required);

        // Insert options if any
        $fi->addOptions($options, $selectedValue);

        // Return form element
        return $fi;
    }
}

