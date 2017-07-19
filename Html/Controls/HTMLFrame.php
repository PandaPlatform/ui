<?php

/*
 * This file is part of the Panda Ui Package.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Panda\Ui\Html\Controls;

use Exception;
use Panda\Ui\Html\HTMLDocument;
use Panda\Ui\Html\HTMLElement;

/**
 * Class HTMLFrame
 * @package Panda\Ui\Html\Controls
 */
class HTMLFrame extends HTMLElement
{
    /**
     * HTMLFrame constructor.
     *
     * @param HTMLDocument $HTMLDocument
     * @param string       $src
     * @param string       $name
     * @param string       $id
     * @param string       $class
     * @param array        $sandbox
     *
     * @throws Exception
     */
    public function __construct(HTMLDocument $HTMLDocument, $src, $name = '', $id = '', $class = '', $sandbox = [])
    {
        // Set id and create element
        $id = ($id ?: 'ifr_' . mt_rand());
        parent::__construct($HTMLDocument, 'iframe', '', $id, 'uiFrame');

        // Set attributes
        $this->addClass($class);
        $this->attr('src', $src);
        $this->attr('name', $name);

        // Set sandbox
        if (is_array($sandbox) && !empty($sandbox)) {
            $this->attr('sandbox', implode(' ', $sandbox));
        }

        // Set default iframe attributes
        $this->attr('frameborder', 'none');
        $this->attr('seamless', true);
        $this->attr('scrolling', 'auto');
    }
}
