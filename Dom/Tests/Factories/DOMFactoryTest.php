<?php

/*
 * This file is part of the Panda Ui Package.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Panda\Ui\Dom\Tests\Factories;

use Panda\Ui\Dom\DOMPrototype;
use Panda\Ui\Dom\Factories\DOMFactory;
use Panda\Ui\Dom\Handlers\DOMHandler;
use PHPUnit_Framework_TestCase;

/**
 * Class DOMFactoryTest
 * @package Panda\Ui\Dom\Tests\Factories
 */
class DOMFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var DOMFactory
     */
    private $DOMFactory;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->DOMFactory = new DOMFactory();
        $this->DOMFactory->setDOMDocument(new DOMPrototype(new DOMHandler(), $this->DOMFactory));
    }

    /**
     * @covers \Panda\Ui\Dom\Factories\DOMFactory::buildElement
     */
    public function testBuildElement()
    {
        $element = $this->DOMFactory->buildElement('item', 'value');
        $this->assertEquals('item', $element->tagName);
        $this->assertEquals('value', $element->nodeValue);
    }
}
