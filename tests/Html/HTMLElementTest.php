<?php

/*
 * This file is part of the Panda framework Ui component.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Panda\Ui\Tests\Html;

use DOMDocument;
use DOMElement;
use Panda\Ui\Factories\HTMLFactory;
use Panda\Ui\Html\HTMLDocument;
use Panda\Ui\Html\HTMLElement;
use PHPUnit_Framework_TestCase;

// Initialize testing env
include '../init.php';

class HTMLElementTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var HTMLElement
     */
    private $HTMLElement;

    public function setUp()
    {
        parent::setUp();

        $this->HTMLElement = new HTMLElement(new HTMLDocument(new HTMLFactory()), $name = 'div', $value = 'value', $id = 'id', $class = 'class');
    }

    public function testHTMLElement()
    {
        $this->assertEquals('div', $this->HTMLElement->tagName);
        $this->assertEquals('value', $this->HTMLElement->nodeValue);
        $this->assertEquals('id', $this->HTMLElement->getAttribute('id'));
        $this->assertEquals('class', $this->HTMLElement->getAttribute('class'));
    }

    public function testFromDOMElement()
    {
        // Setup DOMElement
        $document = new DOMDocument();
        $t = new DOMElement('dom', 'test', '');
        $document->appendChild($t);

        // Check element
        $newElement = $this->HTMLElement->fromDOMElement($t);
        $this->assertEquals('dom', $newElement->tagName);
        $this->assertEquals('test', $newElement->nodeValue);

        // Check with attributes
        $t->setAttribute('t1', 't1');
        $t->setAttribute('t2', 't2');
        $newElement = $this->HTMLElement->fromDOMElement($t);
        $this->assertEquals('t1', $newElement->attr('t1'));

        // Check inner html
        $s = new DOMElement('s', 'new_element');
        $t->appendChild($s);
        $s->setAttribute('t3', 't3');
        $newElement = $this->HTMLElement->fromDOMElement($t);
        $this->assertEquals('test<s t3="t3">new_element</s>', $newElement->innerHTML());
    }

    public function testAddRemoveHasClass()
    {
        // Add classes
        $this->HTMLElement->addClass('class2');
        $this->assertEquals('class class2', $this->HTMLElement->getAttribute('class'));

        $this->HTMLElement->addClass('class3');
        $this->assertEquals('class class2 class3', $this->HTMLElement->getAttribute('class'));

        // Has class
        $this->assertTrue($this->HTMLElement->hasClass('class'));
        $this->assertTrue($this->HTMLElement->hasClass('class2'));
        $this->assertTrue($this->HTMLElement->hasClass('class3'));

        // Remove classes
        $this->HTMLElement->removeClass('class2');
        $this->assertEquals('class class3', $this->HTMLElement->getAttribute('class'));

        $this->HTMLElement->removeClass('class');
        $this->assertEquals('class3', $this->HTMLElement->getAttribute('class'));

        // Has class
        $this->assertFalse($this->HTMLElement->hasClass('class'));
        $this->assertFalse($this->HTMLElement->hasClass('class2'));
    }

    public function testStyle()
    {
        // Add style and check
        $this->HTMLElement->style($name = 'color', $val = 'red');
        $this->assertEquals('color: red', $this->HTMLElement->getAttribute('style'));

        // Add new style
        $this->HTMLElement->style($name = 'background', $val = 'blue');
        $this->assertEquals('color: red; background: blue', $this->HTMLElement->getAttribute('style'));

        // Check style value
        $this->assertEquals('red', $this->HTMLElement->style($name = 'color'));
        $this->assertEquals('blue', $this->HTMLElement->style($name = 'background'));

        // Check remove style
        $this->HTMLElement->style($name = 'background', $val = null);
        $this->assertEmpty($this->HTMLElement->style($name = 'background'));
        $this->assertEquals('color: red', $this->HTMLElement->getAttribute('style'));
    }

    public function testInnerHtml()
    {
        // Simple text as html
        $this->HTMLElement->innerHTML($value = 'test', $faultTolerant = true, $convertEncoding = true);
        $this->assertEquals('test', $this->HTMLElement->nodeValue);

        // More advanced html
        $content = 'This is a custom html content';
        $html = '<div>' . $content . '</div>';
        $this->HTMLElement->innerHTML($value = $html, $faultTolerant = true, $convertEncoding = true);
        $this->assertEquals($content, $this->HTMLElement->nodeValue);
        $this->assertEquals($html, $this->HTMLElement->innerHTML());

        // Check emptying the html
        $this->HTMLElement->innerHTML($value = '', $faultTolerant = true, $convertEncoding = true);
        $this->assertEmpty($this->HTMLElement->innerHTML());
    }

    public function testOuterHtml()
    {
        // Simple text as html
        $this->HTMLElement->innerHTML($value = 'test', $faultTolerant = true, $convertEncoding = true);
        $this->assertEquals('test', $this->HTMLElement->nodeValue);

        // Check outer html
        $this->assertEquals('<div id="id" class="class">test</div>', $this->HTMLElement->outerHTML());
    }
}
