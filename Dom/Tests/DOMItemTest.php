<?php

/*
 * This file is part of the Panda Ui Package.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Panda\Ui\Dom\Tests;

use Exception;
use Panda\Ui\Dom\DOMItem;
use Panda\Ui\Dom\DOMPrototype;
use Panda\Ui\Dom\Factories\DOMFactory;
use Panda\Ui\Dom\Handlers\DOMHandler;
use PHPUnit_Framework_TestCase;

/**
 * Class DOMItemTest
 * @package Panda\Ui\Dom\Tests
 */
class DOMItemTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var DOMItem
     */
    private $DOMItem;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->DOMItem = new DOMItem(new DOMPrototype(new DOMHandler(), new DOMFactory()), 'item', 'value');
    }

    /**
     * @covers \Panda\Ui\Dom\DOMItem::__construct
     */
    public function testDOMItem()
    {
        $this->assertEquals('item', $this->DOMItem->tagName);
        $this->assertEquals('value', $this->DOMItem->nodeValue());
    }

    /**
     * @covers \Panda\Ui\Dom\DOMItem::attr
     * @throws Exception
     */
    public function testAttr()
    {
        // Test simple attribute
        $this->DOMItem->attr('test_attr', 'attr_value');
        $this->assertEquals('attr_value', $this->DOMItem->getAttribute('test_attr'));
    }

    /**
     * @covers \Panda\Ui\Dom\DOMItem::appendAttr
     * @throws Exception
     */
    public function testAppendAttr()
    {
        // Test simple attribute
        $this->DOMItem->attr('test_attr', 'attr_value');
        $this->assertEquals('attr_value', $this->DOMItem->getAttribute('test_attr'));

        // Test append attribute
        $this->DOMItem->appendAttr('test_attr', 'new_attr_value');
        $this->assertEquals('attr_value new_attr_value', $this->DOMItem->getAttribute('test_attr'));
    }

    /**
     * @covers \Panda\Ui\Dom\DOMItem::nodeValue
     */
    public function testNodeValue()
    {
        $this->DOMItem->nodeValue('new_node_value');
        $this->assertEquals('new_node_value', $this->DOMItem->nodeValue);
    }

    /**
     * @covers \Panda\Ui\Dom\DOMItem::append
     * @throws \InvalidArgumentException
     */
    public function testAppend()
    {
        $newItem = new DOMItem($this->DOMItem->getDOMDocument(), 'new');
        $this->DOMItem->append($newItem);
        $this->assertEquals($newItem->parentNode, $this->DOMItem);
        $this->assertEquals($newItem->ownerDocument, $this->DOMItem->ownerDocument);
    }

    /**
     * @covers \Panda\Ui\Dom\DOMItem::prepend
     * @throws \InvalidArgumentException
     */
    public function testPrepend()
    {
        // Simple prepend
        $newItem = new DOMItem($this->DOMItem->getDOMDocument(), 'new');
        $this->DOMItem->prepend($newItem);
        $this->assertEquals($newItem->parentNode, $this->DOMItem);
        $this->assertEquals($newItem->ownerDocument, $this->DOMItem->ownerDocument);

        // Check actual prepend (in the beginning of the DOMElement)
        $newItem = new DOMItem($this->DOMItem->getDOMDocument(), 'new2');
        $this->DOMItem->prepend($newItem);
        $this->assertEquals($newItem->parentNode, $this->DOMItem);
        $this->assertEquals($newItem->ownerDocument, $this->DOMItem->ownerDocument);
        $this->assertEquals($newItem, $this->DOMItem->childNodes->item(0));
    }

    /**
     * @covers \Panda\Ui\Dom\DOMItem::remove
     * @throws \DOMException
     */
    public function testRemove()
    {
        $this->DOMItem->remove();
        $this->assertNull($this->DOMItem->parentNode);
    }

    /**
     * @covers \Panda\Ui\Dom\DOMItem::replace
     * @throws \DOMException
     */
    public function testReplace()
    {
        $newItem = new DOMItem($this->DOMItem->getDOMDocument(), 'new');
        $this->assertEquals($newItem, $this->DOMItem->replace($newItem));
    }
}
