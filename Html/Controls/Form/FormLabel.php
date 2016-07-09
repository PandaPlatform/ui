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

namespace Panda\Ui\Html\Controls\Form;

use Exception;
use Panda\Ui\DOMItem;
use Panda\Ui\Html\HTMLDocument;

/**
 * Class FormLabel
 *
 * @package Panda\Ui\Html\Controls\Form
 *
 * @version 0.1
 */
class FormLabel extends FormElement
{
    /**
     * Create a new form input item.
     *
     * @param HTMLDocument   $HTMLDocument The label's parent document.
     * @param string|DOMItem $content      The label value.
     * @param string         $for          The for attribute, the element's id that the label is pointing to.
     *
     * @throws Exception
     */
    public function __construct(HTMLDocument $HTMLDocument, $content = '', $for = '')
    {
        // Create HTMLElement
        parent::__construct($HTMLDocument, $name = 'label', $name = '', $value = '', $id = '', $class = '', $content);

        // Add extra attributes
        $this->attr('for', $for);
    }
}
