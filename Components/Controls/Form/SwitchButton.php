<?php

/*
 * This file is part of the Panda Ui Package.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Panda\Ui\Components\Controls\Form;

use Exception;
use InvalidArgumentException;
use Panda\Ui\Dom\DOMBuilder;
use Panda\Ui\Html\Controls\Form\FormInput;
use Panda\Ui\Html\HTMLDocument;
use Panda\Ui\Html\HTMLElement;

/**
 * Class FormSwitchButton
 * @package Panda\Ui\Html\Controls\Form
 */
class SwitchButton extends HTMLElement implements DOMBuilder
{
    /**
     * @var bool
     */
    private $active;

    /**
     * Create a new switch button item.
     *
     * @param HTMLDocument $HTMLDocument The item's parent document
     * @param bool         $active       Whether the switch is on or off
     * @param string       $class        The item class attribute
     *
     * @throws Exception
     */
    public function __construct(HTMLDocument $HTMLDocument, $active = false, $class = '')
    {
        // Create HTMLElement
        parent::__construct($HTMLDocument, 'div', null, $id = '', $class);
        $this->active = $active;

        // Add extra attributes
        $this->addClass('uiSwitchButton');
        if ($this->active) {
            $this->addClass('on');
        }
    }

    /**
     * Build the switch button
     *
     * @param string $itemName
     * @param string $itemValue
     *
     * @return $this
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function build($itemName = '', $itemValue = '')
    {
        // Create hidden checkbox
        $fi = new FormInput($this->getHTMLDocument(), 'checkbox', $itemName, $id = '', $class = 'swt_chk', $itemValue, $required = false);
        $this->append($fi);

        // Set checked value for checkbox
        if ($this->active) {
            $fi->attr('checked', 'checked');
        }

        // Add switch
        $switch = $this->getHTMLDocument()->create('div', '', '', 'switch');
        $this->append($switch);

        return $this;
    }
}
