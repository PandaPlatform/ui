<?php

/*
 * This file is part of the Panda Ui Package.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Panda\Ui\Components\Templates\Forms;

use Exception;
use InvalidArgumentException;
use Panda\Ui\Components\Controls\Form as FormControl;
use Panda\Ui\Components\DOMBuilder;
use Panda\Ui\Html\HTMLElement;

/**
 * Form Builder Prototype
 *
 * It's the prototype for building every form in the system.
 * All the form objects must inherit this FormPrototype in order to build the spine of a form well-formed.
 * It implements the FormProtocol.
 *
 * @package Panda\Ui\Html\Templates\Forms
 */
class Form extends FormControl implements DOMBuilder
{
    /**
     * The form report container class.
     *
     * @var string
     */
    const FORM_REPORT_CLASS = 'form-report';

    /**
     * The form's id.
     *
     * @var string
     */
    protected $formId;

    /**
     * The form report element container.
     *
     * @var HTMLElement
     */
    protected $formReport;

    /**
     * The form body element container.
     *
     * @var HTMLElement
     */
    protected $formBody;

    /**
     * Defines whether the form will prevent page unload on edit.
     *
     * @var bool
     */
    protected $pu = false;

    /**
     * Build the form element.
     *
     * @param string $id         The form id.
     * @param string $action     The form action url string.
     * @param bool   $async      Sets the async attribute for simple forms.
     * @param bool   $fileUpload This marks the form ready for file upload. It adds the enctype attribute where no
     *                           characters are encoded. This value is required when you are using forms that have a
     *                           file upload control.
     *
     * @return $this
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function build($id = '', $action = '', $async = true, $fileUpload = false)
    {
        // Set the formID
        $this->formId = ($id ?: 'f' . mt_rand());

        // Build the form
        parent::build($id, $action, $async, $fileUpload);

        // Add extra class
        $this->addClass('form-template');

        // Create form report element
        $this->formReport = $this->getHTMLDocument()->getHTMLFactory()->buildHtmlElement('div', '', '', self::FORM_REPORT_CLASS);
        $this->append($this->formReport);

        // Create form body element
        $this->formBody = $this->getHTMLDocument()->getHTMLFactory()->buildHtmlElement('div', '', '', 'form-body');
        $this->append($this->formBody);

        return $this;
    }

    /**
     * @return string
     */
    public function getFormId()
    {
        return $this->formId;
    }

    /**
     * Create a system specific form input id.
     *
     * @param string $name The input's name.
     *
     * @return string The input id
     */
    protected function getInputId($name)
    {
        return empty($name) ? '' : 'i' . $this->getFormId() . '_' . $name . mt_rand();
    }

    /**
     * Appends a DOMElement to the form body.
     *
     * @param HTMLElement $element
     *
     * @return $this
     * @throws InvalidArgumentException
     */
    public function appendToBody($element)
    {
        $this->formBody->append($element);

        return $this;
    }

    /**
     * Appends a DOMElement to the form report container.
     *
     * @param HTMLElement $element
     *
     * @return $this
     * @throws InvalidArgumentException
     */
    public function appendToReport($element)
    {
        $this->formReport->append($element);

        return $this;
    }
}
