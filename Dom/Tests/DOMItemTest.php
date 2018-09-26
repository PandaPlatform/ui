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
use PHPUnit\Framework\TestCase;

/**
 * Class DOMItemTest
 * @package Panda\Ui\Dom\Tests
 */
class DOMItemTest extends TestCase
{
    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * @covers \Panda\Ui\Dom\DOMItem::__construct
     *
     * @return DOMItem
     * @throws \InvalidArgumentException
     */
    public function testDOMItem()
    {
        // Create new DOMItem
        $tagName = 'item';
        $nodeValue = 'value';
        $domItem = new DOMItem(new DOMPrototype(new DOMHandler(), new DOMFactory()), $tagName, $nodeValue);

        // Assert properties
        $this->assertEquals($tagName, $domItem->tagName);
        $this->assertEquals($nodeValue, $domItem->nodeValue());

        return $domItem;
    }

    /**
     * @covers \Panda\Ui\Dom\DOMItem::__construct
     *
     * @return DOMItem
     * @throws \InvalidArgumentException
     */
    public function testDOMItemWithNamespace()
    {
        // Create new DOMItem
        $tagName = 'item:namespace';
        $nodeValue = 'value';
        $namespaceURI = 'http://xyz';
        $domItem = new DOMItem(new DOMPrototype(new DOMHandler(), new DOMFactory()), $tagName, $nodeValue, $namespaceURI);

        // Assert properties
        $this->assertEquals($tagName, $domItem->tagName);
        $this->assertEquals($nodeValue, $domItem->nodeValue());

        return $domItem;
    }

    /**
     * @covers \Panda\Ui\Dom\DOMItem::attr
     * @throws Exception
     */
    public function testAttr()
    {
        // Create DOMItem
        $domItem = $this->testDOMItem();

        // Test simple attribute
        $domItem->attr('test_attr', 'attr_value');
        $this->assertEquals('attr_value', $domItem->getAttribute('test_attr'));

        // Test array attribute
        $array = ['name' => 'value'];
        $domItem->attr('test_attr', $array);
        $this->assertEquals(json_encode($array, JSON_FORCE_OBJECT), $domItem->getAttribute('test_attr'));
    }

    /**
     * @covers \Panda\Ui\Dom\DOMItem::appendAttr
     * @throws Exception
     */
    public function testAppendAttr()
    {
        // Create DOMItem
        $domItem = $this->testDOMItem();

        // Test simple attribute
        $domItem->attr('test_attr', 'attr_value');
        $this->assertEquals('attr_value', $domItem->getAttribute('test_attr'));

        // Test append attribute
        $domItem->appendAttr('test_attr', 'new_attr_value');
        $this->assertEquals('attr_value new_attr_value', $domItem->getAttribute('test_attr'));
    }

    /**
     * @covers \Panda\Ui\Dom\DOMItem::nodeValue
     * @throws \InvalidArgumentException
     */
    public function testNodeValue()
    {
        // Create DOMItem
        $domItem = $this->testDOMItem();

        // Assert values
        $domItem->nodeValue('new_node_value');
        $this->assertEquals('new_node_value', $domItem->nodeValue);
    }

    /**
     * @covers \Panda\Ui\Dom\DOMItem::append
     * @throws \InvalidArgumentException
     */
    public function testAppend()
    {
        // Create DOMItem
        $domItem = $this->testDOMItem();

        $newItem = new DOMItem($domItem->getDOMDocument(), 'new');
        $domItem->append($newItem);
        $this->assertEquals($newItem->parentNode, $domItem);
        $this->assertEquals($newItem->ownerDocument, $domItem->ownerDocument);
    }

    /**
     * @covers \Panda\Ui\Dom\DOMItem::prepend
     * @throws \InvalidArgumentException
     */
    public function testPrepend()
    {
        // Create DOMItem
        $domItem = $this->testDOMItem();

        // Simple prepend
        $newItem = new DOMItem($domItem->getDOMDocument(), 'new');
        $domItem->prepend($newItem);
        $this->assertEquals($newItem->parentNode, $domItem);
        $this->assertEquals($newItem->ownerDocument, $domItem->ownerDocument);

        // Check actual prepend (in the beginning of the DOMElement)
        $newItem = new DOMItem($domItem->getDOMDocument(), 'new2');
        $domItem->prepend($newItem);
        $this->assertEquals($newItem->parentNode, $domItem);
        $this->assertEquals($newItem->ownerDocument, $domItem->ownerDocument);
        $this->assertEquals($newItem, $domItem->childNodes->item(0));
    }

    /**
     * @covers \Panda\Ui\Dom\DOMItem::remove
     * @throws \DOMException
     * @throws \InvalidArgumentException
     */
    public function testRemove()
    {
        // Create DOMItem
        $domItem = $this->testDOMItem();

        $domItem->remove();
        $this->assertNull($domItem->parentNode);
    }

    /**
     * @covers \Panda\Ui\Dom\DOMItem::replace
     * @throws \DOMException
     * @throws \InvalidArgumentException
     */
    public function testReplace()
    {
        // Create DOMItem
        $domItem = $this->testDOMItem();

        $newItem = new DOMItem($domItem->getDOMDocument(), 'new');
        $this->assertEquals($newItem, $domItem->replace($newItem));
    }
}
