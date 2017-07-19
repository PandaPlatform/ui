<?php

/*
 * This file is part of the Panda Ui Package.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Panda\Ui\Tests\Html;

use Panda\Ui\Factories\HTMLFactory;
use Panda\Ui\Handlers\HTMLHandler;
use Panda\Ui\Components\HTMLDocument;
use Panda\Ui\Components\HTMLElement;
use PHPUnit_Framework_TestCase;

/**
 * Class HTMLElementTest
 * @package Panda\Ui\Tests\Html
 */
class HTMLElementTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var HTMLElement
     */
    private $HTMLElement;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->HTMLElement = new HTMLElement(new HTMLDocument(new HTMLHandler(), new HTMLFactory()), $name = 'div', $value = 'value', $id = 'id', $class = 'class');
    }

    /**
     * @covers \Panda\Ui\Html\HTMLElement::__construct
     */
    public function testHTMLElement()
    {
        $this->assertEquals('div', $this->HTMLElement->tagName);
        $this->assertEquals('value', $this->HTMLElement->nodeValue);
        $this->assertEquals('id', $this->HTMLElement->getAttribute('id'));
        $this->assertEquals('class', $this->HTMLElement->getAttribute('class'));
    }

    /**
     * @covers \Panda\Ui\Html\HTMLElement::data
     */
    public function testData()
    {
        // Test data array
        $data = [];
        $data['t1'] = 't1_value';
        $data['t2'] = 't2_value';
        $this->HTMLElement->data('test', $data);
        $this->assertEquals(json_encode($data, JSON_FORCE_OBJECT), $this->HTMLElement->getAttribute('data-test'));

        // Test empty array
        $data = [];
        $this->HTMLElement->data('test-empty', $data);
        $this->assertEquals(json_encode($data, JSON_FORCE_OBJECT), '{' . $this->HTMLElement->getAttribute('data-test-empty') . '}');
    }

    /**
     * @covers \Panda\Ui\Html\HTMLElement::addClass
     * @covers \Panda\Ui\Html\HTMLElement::hasClass
     * @covers \Panda\Ui\Html\HTMLElement::removeClass
     *
     * @throws \Exception
     * @throws \PHPUnit_Framework_AssertionFailedError
     */
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

    /**
     * @covers \Panda\Ui\Html\HTMLElement::style
     * @throws \PHPUnit_Framework_AssertionFailedError
     */
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

    /**
     * @covers \Panda\Ui\Html\HTMLElement::innerHTML
     * @throws \PHPUnit_Framework_AssertionFailedError
     */
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

    /**
     * @covers \Panda\Ui\Html\HTMLElement::innerHTML
     */
    public function testOuterHtml()
    {
        // Simple text as html
        $this->HTMLElement->innerHTML($value = 'test', $faultTolerant = true, $convertEncoding = true);
        $this->assertEquals('test', $this->HTMLElement->nodeValue);

        // Check outer html
        $this->assertEquals('<div id="id" class="class">test</div>', $this->HTMLElement->outerHTML());
    }
}
