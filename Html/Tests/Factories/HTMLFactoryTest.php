<?php

/*
 * This file is part of the Panda Ui Package.
 *
 * (c) Ioannis Papikas <papikas.ioan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Panda\Ui\Html\Tests\Factories;

use Panda\Ui\Html\Factories\HTMLFactory;
use Panda\Ui\Html\Handlers\HTMLHandler;
use Panda\Ui\Html\HTMLDocument;
use PHPUnit\Framework\TestCase;

/**
 * Class HTMLFactoryTest
 * @package Panda\Ui\Html\Tests\Factories
 */
class HTMLFactoryTest extends TestCase
{
    /**
     * @var HTMLFactory
     */
    private $HTMLFactory;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->HTMLFactory = new HTMLFactory();
        $this->HTMLFactory->setHTMLDocument(new HTMLDocument(new HTMLHandler(), $this->HTMLFactory));
    }

    /**
     * @covers \Panda\Ui\Html\Factories\HTMLFactory::buildHtmlElement
     */
    public function testBuildElement()
    {
        $element = $this->HTMLFactory->buildHtmlElement($name = 'item', $value = 'value', $id = 'id', $class = 'class');
        $this->assertEquals('item', $element->tagName);
        $this->assertEquals('value', $element->nodeValue);
        $this->assertEquals('id', $element->getAttribute('id'));
        $this->assertEquals('class', $element->getAttribute('class'));
    }

    /**
     * @covers \Panda\Ui\Html\Factories\HTMLFactory::buildWebLink
     * @throws \Exception
     */
    public function testBuildWebLink()
    {
        $element = $this->HTMLFactory->buildWebLink($href = 'http://test.example.com', $target = '_self', $content = 'test_weblink', $id = 'weblink_id', $class = 'weblink_class');
        $this->assertEquals('a', $element->tagName);
        $this->assertEquals('test_weblink', $element->nodeValue);
        $this->assertEquals('weblink_id', $element->getAttribute('id'));
        $this->assertEquals('weblink_class', $element->getAttribute('class'));
        $this->assertEquals('http://test.example.com', $element->getAttribute('href'));
        $this->assertEquals('_self', $element->getAttribute('target'));
    }

    /**
     * @covers \Panda\Ui\Html\Factories\HTMLFactory::buildMeta
     * @throws \Exception
     */
    public function testBuildMeta()
    {
        $element = $this->HTMLFactory->buildMeta($name = 'test_meta', $content = 'meta_content', $httpEquiv = 'http_equiv', $charset = 'utf-8');
        $this->assertEquals('meta', $element->tagName);
        $this->assertEquals('test_meta', $element->getAttribute('name'));
        $this->assertEquals('meta_content', $element->getAttribute('content'));
        $this->assertEquals('http_equiv', $element->getAttribute('http-equiv'));
        $this->assertEquals('utf-8', $element->getAttribute('charset'));
    }

    /**
     * @covers \Panda\Ui\Html\Factories\HTMLFactory::buildLink
     * @throws \Exception
     */
    public function testBuildLink()
    {
        $element = $this->HTMLFactory->buildLink($rel = 'rel', $href = 'http://test.link.com');
        $this->assertEquals('link', $element->tagName);
        $this->assertEquals('rel', $element->getAttribute('rel'));
        $this->assertEquals('http://test.link.com', $element->getAttribute('href'));
    }

    /**
     * @covers \Panda\Ui\Html\Factories\HTMLFactory::buildScript
     * @throws \Exception
     */
    public function testBuildScript()
    {
        $element = $this->HTMLFactory->buildScript($src = 'http://test.script.com', $async = true);
        $this->assertEquals('script', $element->tagName);
        $this->assertEquals('', $element->getAttribute('async'));
        $this->assertEquals('http://test.script.com', $element->getAttribute('src'));
    }
}
