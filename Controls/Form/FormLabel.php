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

namespace Panda\Ui\Controls\Form;

use Exception;
use Panda\Ui\Html\HTMLDocument;

/**
 * Class FormLabel
 *
 * @package Panda\Ui\Controls\Form
 * @version 0.1
 */
class FormLabel extends FormElement
{
    /**
     * Create a new form input item.
     *
     * @param HTMLDocument $HTMLDocument The DOMDocument to create the element
     * @param null         $content      The label value. It  can be string or DOMElement.
     *                                   It is NULL by default.
     * @param string       $for          The element's id that the label is pointing to.
     *                                   The 'for' attribute.
     *
     * @throws Exception
     *
     */
    public function __construct(HTMLDocument $HTMLDocument, $content = null, $for = '')
    {
        // Create HTMLElement
        parent::__construct($HTMLDocument, $name = 'label', $name = '', $value = '', $id = '', $class = '', $content);

        // Add extra attributes
        $this->attr('for', $for);
    }
}

