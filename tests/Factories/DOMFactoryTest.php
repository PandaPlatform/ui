<?php

/*
 * This file is part of the Panda framework Ui component.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Panda\Ui\Tests\Factories;

use Panda\Ui\Factories\DOMFactory;
use PHPUnit_Framework_TestCase;

// Initialize testing env
include '../init.php';

class DOMFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var DOMFactory
     */
    private $DOMFactory;

    public function setUp()
    {
        parent::setUp();

        $this->DOMFactory = new DOMFactory();
    }

    public function testBuildElement()
    {
        $element = $this->DOMFactory->buildElement('item', 'value');
        $this->assertEquals('item', $element->tagName);
        $this->assertEquals('value', $element->nodeValue);
    }
}
