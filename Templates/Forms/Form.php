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

namespace Panda\Ui\Templates\Forms;

use Panda\Ui\Contracts\DOMBuilder;
use Panda\Ui\Contracts\Factories\HTMLFormFactoryInterface;
use Panda\Ui\Controls\Form as FormControl;
use Panda\Ui\Html\HTMLDocument;
use Panda\Ui\Html\HTMLElement;

/**
 * Form Builder Prototype
 *
 * It's the prototype for building every form in the system.
 * All the form objects must inherit this FormPrototype in order to build the spine of a form well-formed.
 * It implements the FormProtocol.
 *
 * @package Panda\Ui\Templates\Forms
 * @version 0.1
 */
class Form extends FormControl implements DOMBuilder
{
    /**
     * The form report container class.
     *
     * @type    string
     */
    const FORM_REPORT_CLASS = "form-report";

    /**
     * The form's id.
     *
     * @type    string
     */
    protected $formId;

    /**
     * The form report element container.
     *
     * @type HTMLElement
     */
    protected $formReport;

    /**
     * The form body element container.
     *
     * @type HTMLElement
     */
    protected $formBody;

    /**
     * Defines whether the form will prevent page unload on edit.
     *
     * @type bool
     */
    protected $pu = false;

    /**
     * @param HTMLDocument             $HTMLDocument    The DOMDocument to create the element
     * @param HTMLFormFactoryInterface $HTMLFormFactory The Form Factory interface to generate all elements.
     * @param string                   $id              The form id.
     * @param string                   $action          The form action url string.
     *                                                  It is empty by default.
     * @param bool                     $async           Sets the async attribute for simple forms.
     *                                                  It is TRUE by default.
     * @param bool                     $fileUpload      This marks the form ready for file upload. It adds the enctype
     *                                                  attribute where no characters are encoded. This value is
     *                                                  required when you are using forms that have a file upload
     *                                                  control. It is FALSE by default.
     */
    public function __construct(HTMLDocument $HTMLDocument, $HTMLFormFactory = null, $id = "", $action = "", $async = true, $fileUpload = false)
    {
        // Set the formID
        $this->formId = ($id ?: "f" . mt_rand());

        // Create Form element
        parent::__construct($HTMLDocument, $HTMLFormFactory, $this->formId, $action, $async, $fileUpload);

        // Add extra class
        $this->addClass("form-template");
    }

    /**
     * Builds the form spine and sets the UIObject.
     */
    public function build()
    {
        // Create form report element
        $this->formReport = $this->getHTMLDocument()->create("div", "", "", self::FORM_REPORT_CLASS);
        $this->append($this->formReport);

        // Create form body element
        $this->formBody = $this->getHTMLDocument()->create("div", "", "", "form-body");
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
        return (empty($name) ? "" : "i" . $this->getFormId() . "_" . $name . mt_rand());
    }

    /**
     * Appends a DOMElement to the form body.
     *
     * @param HTMLElement $element
     *
     * @return $this
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
     */
    public function appendToReport($element)
    {
        $this->formReport->append($element);

        return $this;
    }
}

?>