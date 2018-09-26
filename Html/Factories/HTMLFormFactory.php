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

use Exception;
use InvalidArgumentException;
use Panda\Ui\Html\Controls\Form;
use Panda\Ui\Html\Controls\Form\FormButton;
use Panda\Ui\Html\Controls\Form\FormElement;
use Panda\Ui\Html\Controls\Form\FormInput;
use Panda\Ui\Html\Controls\Form\FormLabel;
use Panda\Ui\Html\Controls\Form\FormSelect;

/**
 * Class HTMLFormFactory
 * @package Panda\Ui\Html\Factories
 */
class HTMLFormFactory extends HTMLFactory implements HTMLFormFactoryInterface
{
    /**
     * Build a form control.
     *
     * @param string $id
     * @param string $action
     * @param bool   $async
     * @param bool   $fileUpload
     * @param array  $attributes
     *
     * @return Form
     * @throws Exception
     */
    public function buildForm($id = '', $action = '', $async = false, $fileUpload = false, $attributes = [])
    {
        // Create form control
        $form = new Form($this->getHTMLDocument(), $this, $attributes);
        $form->build($id, $action, $async, $fileUpload);

        return $form;
    }

    /**
     * Build an html form element.
     *
     * @param string $itemName
     * @param string $name
     * @param string $value
     * @param string $id
     * @param string $class
     * @param string $itemValue
     * @param array  $attributes
     *
     * @return FormElement
     * @throws Exception
     */
    public function buildFormElement($itemName = '', $name = '', $value = '', $id = '', $class = '', $itemValue = '', $attributes = [])
    {
        // Create form input
        $id = $id ?: 'fe' . mt_rand();
        $element = new FormElement($this->getHTMLDocument(), $itemName, $name, $value, $id, $class, $itemValue, $attributes);

        // Return form element
        return $element;
    }

    /**
     * Builds and returns an input item.
     *
     * @param string $type       The input's type. This must abide by the rules of the possible input types.
     * @param string $name       The input's name.
     * @param string $value      The input's default value.
     * @param string $id         The input's id attribute.
     * @param string $class      The extra class for the input.
     * @param bool   $autofocus  Inserts the autofocus attribute to the input.
     * @param bool   $required   Indicates this input as required.
     * @param array  $attributes A set of extra attributes
     *
     * @return FormElement
     * @throws Exception
     */
    public function buildInput($type = 'text', $name = '', $value = '', $id = '', $class = '', $autofocus = false, $required = false, $attributes = [])
    {
        // Create form input
        $id = $id ?: 'fi' . mt_rand();
        $element = new FormInput($this->getHTMLDocument(), $type, $name, $id, $class, $value, $required, $attributes);

        // Add extra attributes
        $element->attr('autofocus', $autofocus);

        // Return form element
        return $element;
    }

    /**
     * Build an html form file input.
     *
     * @param string $name       The input's name.
     * @param string $id         The input's id attribute.
     * @param string $class      The extra class for the input.
     * @param bool   $required   Indicates this input as required.
     * @param string $accept     The accept attribute for the file dialog.
     * @param array  $attributes A set of extra attributes
     *
     * @return FormElement
     * @throws Exception
     */
    public function buildFileInput($name = '', $id = '', $class = '', $required = false, $accept = '', $attributes = [])
    {
        // Create file input
        $id = $id ?: 'ffi' . mt_rand();
        $element = $this->buildInput($type = 'file', $name, $value = '', $id, $class, $autofocus = false, $required, $attributes);

        // Set accept attribute
        $element->attr('accept', $accept);

        // Return form element
        return $element;
    }

    /**
     * Build an html form label.
     *
     * @param string $content    The label content.
     * @param string $for        The input's id where this label is pointing to.
     * @param string $class      The extra class for the label.
     * @param array  $attributes A set of extra attributes
     *
     * @return FormElement
     * @throws Exception
     */
    public function buildLabel($content, $for = '', $class = '', $attributes = [])
    {
        // Create new form label
        $element = new FormLabel($this->getHTMLDocument(), $content, $for, $attributes);

        // Add class
        $element->addClass($class);

        // Return form element
        return $element;
    }

    /**
     * Built an html form button.
     *
     * @param string $type       The button's type
     * @param string $title      The button's title
     * @param string $name       The button's name attribute
     * @param string $id         The button's id attribute.
     * @param string $class      The extra class of the button
     * @param array  $attributes A set of extra attributes
     *
     * @return FormElement
     * @throws Exception
     */
    public function buildButton($type, $title, $name = '', $id = '', $class = '', $attributes = [])
    {
        // Create new form button
        $id = $id ?: 'fb' . mt_rand();
        $element = new FormButton($this->getHTMLDocument(), $type, $name, $id, $title, $attributes);

        // Add class
        $element->addClass($class);

        // Return form element
        return $element;
    }

    /**
     * Built an html form submit button.
     *
     * @param string $title      The button's title
     * @param string $name       The button's name attribute
     * @param string $id         The button's id attribute
     * @param string $class      The extra class of the button
     * @param array  $attributes A set of extra attributes
     *
     * @return FormElement
     * @throws Exception
     */
    public function buildSubmitButton($title, $name = '', $id = '', $class = '', $attributes = [])
    {
        // Create the form submit button
        $id = $id ?: 'fsb' . mt_rand();

        return $this->buildButton($type = 'submit', $title, $name, $id, $class, $attributes);
    }

    /**
     * Built an html form reset button.
     *
     * @param string $title      The button's title
     * @param string $id         The button's id attribute
     * @param string $class      The extra class of the button
     * @param array  $attributes A set of extra attributes
     *
     * @return FormElement
     * @throws Exception
     */
    public function buildResetButton($title, $id = '', $class = '', $attributes = [])
    {
        // Create the form reset button
        $id = $id ?: 'frb' . mt_rand();

        return $this->buildButton($type = 'reset', $title, $name = '', $id, $class, $attributes);
    }

    /**
     * Build an html form textarea.
     *
     * @param string $name       The textarea's name.
     * @param string $value      The textarea's default value.
     * @param string $id         The textarea's id attribute
     * @param string $class      The extra class for the textarea.
     * @param bool   $autofocus  Inserts the autofocus attribute to the input.
     * @param bool   $required   Indicates this textarea as required.
     * @param array  $attributes A set of extra attributes
     *
     * @return FormElement
     * @throws Exception
     */
    public function buildTextarea($name = '', $value = '', $id = '', $class = '', $autofocus = false, $required = false, $attributes = [])
    {
        // Create Form Item
        $id = $id ?: 'ftxt' . mt_rand();
        $element = $this->buildFormElement($itemName = 'textarea', $name, $id, $value, $class, $itemValue = '', $attributes);
        $element->nodeValue($value);

        // Set attributes
        $element->attr('autofocus', $autofocus);
        $element->attr('required', $required);

        // Return form element
        return $element;
    }

    /**
     * Build an html form fieldset element.
     *
     * @param string $title      The fieldset legend title.
     * @param string $name       The fieldset name.
     * @param string $id         The fieldset id.
     * @param string $class      The fieldset class.
     * @param array  $attributes A set of extra attributes
     *
     * @return FormElement
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public function buildFieldset($title, $name = '', $id = '', $class = '', $attributes = [])
    {
        // Create fieldset item
        $id = $id ?: 'flds' . mt_rand();
        $element = $this->buildFormElement($itemName = 'fieldset', $name, $value = '', $id, $class, $itemValue = '', $attributes);

        // Create and append legend
        $legend = $this->buildElement('legend', $title);
        $element->append($legend);

        // Return form element
        return $element;
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
     * @param array  $attributes    A set of extra attributes
     *
     * @return FormElement
     * @throws Exception
     */
    public function buildSelect($name = '', $multiple = false, $id = '', $class = '', $options = [], $selectedValue = '', $required = false, $attributes = [])
    {
        // Create select form input
        $id = $id ?: 'fs' . mt_rand();
        $element = new FormSelect($this->getHTMLDocument(), $this, $name, $id, $class, $multiple, $required, $attributes);

        // Insert options if any
        $element->addOptions($options, $selectedValue);

        // Return form element
        return $element;
    }
}
