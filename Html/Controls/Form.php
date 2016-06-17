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

namespace Panda\Ui\Html\Controls;

use Exception;
use Panda\Ui\Contracts\DOMBuilder;
use Panda\Ui\Contracts\Factories\HTMLFormFactoryInterface;
use Panda\Ui\Html\HTMLDocument;
use Panda\Ui\Html\HTMLElement;

/**
 * HTML Form Class. Create HTML forms
 *
 * @package Panda\Ui\Html\Controls
 *
 * @version 0.1
 */
class Form extends HTMLElement implements DOMBuilder
{
    /**
     * @var HTMLFormFactoryInterface
     */
    protected $HTMLFormFactory;

    /**
     * Create a new HTML Form.
     *
     * @param HTMLDocument             $HTMLDocument
     * @param HTMLFormFactoryInterface $HTMLFormFactory The Form Factory interface to generate all elements.
     *
     * @throws Exception
     */
    public function __construct(HTMLDocument $HTMLDocument, HTMLFormFactoryInterface $HTMLFormFactory)
    {
        // Create HTML Form element
        parent::__construct($HTMLDocument, $name = 'form', $value = '', $id = '');
        $this->HTMLFormFactory = $HTMLFormFactory;
        $this->HTMLFormFactory->setHTMLDocument($this->getHTMLDocument());
    }

    /**
     * Build the element.
     *
     * @param string $id         The form id.
     * @param string $action     The form action url string.
     * @param bool   $async      Sets the async attribute for simple forms.
     * @param bool   $fileUpload This marks the form ready for file upload. It adds the enctype attribute where no
     *                           characters are encoded. This value is required when you are using forms that have a
     *                           file upload control.
     *
     * @return $this
     */
    public function build($id = '', $action = '', $async = false, $fileUpload = false)
    {
        // Add extra attributes
        $this->attr('id', $id);
        $this->attr('method', 'post');
        $this->attr('action', $action);
        $this->attr('async', $async);

        // Set form for file upload
        if ($fileUpload) {
            $this->attr('enctype', 'multipart/form-data');
        }

        return $this;
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

