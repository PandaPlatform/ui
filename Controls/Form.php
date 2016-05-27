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

namespace Panda\Ui\Html;

use Exception;
use Panda\Ui\Contracts\HTMLFormFactoryInterface;

/**
 * HTML Form Class. Create HTML forms
 *
 * @package Panda\Ui\Html
 * @version 0.1
 */
class Form extends HTMLElement
{
    /**
     * The form's id.
     *
     * @type string
     */
    private $formId;

    /**
     * Defines whether the form will prevent page unload on edit.
     *
     * @type boolean
     */
    private $pu = false;

    /**
     * @type HTMLFormFactoryInterface
     */
    private $HTMLFormFactory;

    /**
     * Create a new HTMLObject.
     *
     * @param HTMLDocument             $HTMLDocument    The DOMDocument to create the element
     * @param HTMLFormFactoryInterface $HTMLFormFactory The Form Factory interface to generate all elements.
     * @param string                   $id              The form id.
     * @param string                   $action          The form action url string.
     *                                                  It is empty by default.
     * @param bool                     $async           Sets the async attribute for simple forms.
     *                                                  It is TRUE by default.
     * @param bool                     $preventUnload   Set an empty value (NULL, FALSE or anything that empty()
     *                                                  returns as TRUE) and it will deactivate this form from
     *                                                  preventing unload. Set TRUE to prevent unload with a system
     *                                                  message or give a message to show to the user specific for this
     *                                                  form. It is FALSE by default.
     * @param bool                     $fileUpload      This marks the form ready for file upload. It adds the enctype
     *                                                  attribute where no characters are encoded. This value is
     *                                                  required when you are using forms that have a file upload
     *                                                  control. It is FALSE by default.
     *
     * @throws Exception
     */
    public function __construct(HTMLDocument $HTMLDocument, HTMLFormFactoryInterface $HTMLFormFactory, $id = "", $action = "", $async = true, $preventUnload = false, $fileUpload = false)
    {
        // Create HTML Form element
        parent::__construct($HTMLDocument, $name = "form", $value = "", $id);
        $this->HTMLFormFactory = $HTMLFormFactory;

        // Set form attributes
        $this->formId = ($id == "" ? "f" . mt_rand() : $id);
        $this->pu = $preventUnload;

        // Add extra attributes
        $this->attr("method", "post");
        $this->attr("action", $action);
        $this->attr("async", $async);

        // Set form for file upload
        if ($fileUpload) {
            $this->attr("enctype", "multipart/form-data");
        }
    }

    /**
     * Create a system specific form input id.
     *
     * @param string $name The input's name.
     *
     * @return string The input id
     */
    protected function getInputID($name)
    {
        return (empty($name) ? "" : "i" . $this->getFormId() . "_" . $name . mt_rand());
    }

    /**
     * @return string
     */
    public function getFormId()
    {
        return $this->formId;
    }

    /**
     * @return HTMLFormFactoryInterface
     */
    public function getHTMLFormFactory()
    {
        return $this->HTMLFormFactory;
    }

    /**
     * @param HTMLFormFactoryInterface $HTMLFormFactory
     */
    public function setHTMLFormFactory($HTMLFormFactory)
    {
        $this->HTMLFormFactory = $HTMLFormFactory;
    }
}

?>