<?php

/*
 * This file is part of the Panda framework Ui component.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Panda\Ui\Tests;

use Panda\Ui\DOMItem;
use PHPUnit_Framework_TestCase;

// Initialize testing env
include 'init.php';

class DOMItemTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var DOMItem
     */
    private $DOMItem;

    public function setUp()
    {
        parent::setUp();

        $this->DOMItem = new DOMItem('item', 'value');
    }

    public function testDOMItem()
    {
        $this->assertEquals('item', $this->DOMItem->tagName);
        $this->assertEquals('value', $this->DOMItem->nodeValue);
    }

    public function testAttr()
    {
        // Test simple attribute
        $this->DOMItem->attr('test_attr', 'attr_value');
        $this->assertEquals('attr_value', $this->DOMItem->getAttribute('test_attr'));

        // Test append attribute
        $this->DOMItem->appendAttr('test_attr', 'new_attr_value');
        $this->assertEquals('attr_value new_attr_value', $this->DOMItem->getAttribute('test_attr'));
    }

    public function testData()
    {
        // Test data array
        $data = [];
        $data['t1'] = 't1_value';
        $data['t2'] = 't2_value';
        $this->DOMItem->data('dtest', $data);
        $this->assertEquals(json_encode($data, JSON_FORCE_OBJECT), $this->DOMItem->getAttribute('data-dtest'));

        // Test empty array
        $data = [];
        $this->DOMItem->data('dtest-empty', $data);
        $this->assertEquals(json_encode($data, JSON_FORCE_OBJECT), '{' . $this->DOMItem->getAttribute('data-dtest-empty') . '}');
    }

    public function testNodeValue()
    {
        $this->DOMItem->nodeValue('new_node_value');
        $this->assertEquals('new_node_value', $this->DOMItem->nodeValue);
    }

    public function testAppend()
    {
        $newItem = new DOMItem('new');
        $this->DOMItem->append($newItem);
        $this->assertEquals($newItem->parentNode, $this->DOMItem);
        $this->assertEquals($newItem->ownerDocument, $this->DOMItem->ownerDocument);
    }

    public function testPrepend()
    {
        // Simple prepend
        $newItem = new DOMItem('new');
        $this->DOMItem->prepend($newItem);
        $this->assertEquals($newItem->parentNode, $this->DOMItem);
        $this->assertEquals($newItem->ownerDocument, $this->DOMItem->ownerDocument);

        // Check actual prepend (in the beginning of the DOMElement)
        $newItem = new DOMItem('new2');
        $this->DOMItem->prepend($newItem);
        $this->assertEquals($newItem->parentNode, $this->DOMItem);
        $this->assertEquals($newItem->ownerDocument, $this->DOMItem->ownerDocument);
        $this->assertEquals($newItem, $this->DOMItem->childNodes->item(0));
    }

    public function testRemove()
    {
        $this->DOMItem->remove();
        $this->assertNull($this->DOMItem->parentNode);
    }

    public function testReplace()
    {
        $newItem = new DOMItem('new');
        $this->assertEquals($newItem, $this->DOMItem->replace($newItem));
    }
}
