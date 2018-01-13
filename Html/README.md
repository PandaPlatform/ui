# Html Package

> **Note:** [READ-ONLY] Subtree split of the Panda Ui Package

The Html Package allows you to create and manipulate Html Controls and other Html specific tools.

[![StyleCI](https://styleci.io/repos/97729727/shield?branch=3.1)](https://styleci.io/repos/97729727/shield?branch=3.1)
[![Latest Stable Version](https://poser.pugx.org/panda/html/v/stable?format=flat-square)](https://packagist.org/packages/panda/html)
[![Total Downloads](https://poser.pugx.org/panda/html/downloads?format=flat-square)](https://packagist.org/packages/panda/html)
[![License](https://poser.pugx.org/panda/html/license?format=flat-square)](https://packagist.org/packages/panda/html)

- [Introduction](#introduction)
- [Installation](#installation)
  - [Through the composer](#through-the-composer)
- [HTML](#html)
  - [HTML Handlers](#html-handlers)
  - [HTML Factories](#html-factories)
  - [HTML Basics](#html-basics)
  - [HTML Forms](#html-forms)

## Introduction
Panda Ui Html component is a backend ui handler/renderer engine that enables generating html content in a more structured way.

This is the main reason why this component is so powerful, providing extra, faster and more clever functionality using existing components.

This package is able to create html pages using the DOM structure fast and easy. Some of the features include:

* Html specific controls and manipulation
* Html controls ready to be used
* Backend Html parsing and selecting using css selectors
* Form factories and builders
* Generic components

## Installation

### Through the composer

Add the following line to your `composer.json` file:

```
"panda/html": "^3.1"
```

## HTML

### HTML Handlers

HTMLHandler extends DOMHandler functionality with HTML specific functions. It provides easy-to-use one-line functions for handling HTML specific attributes so that we can make HTML rendering and manipulation easier. Examples:

```php
use \Panda\Ui\Html\Handlers\HTMLHandler;

$handler = new HTMLHandler();

// Using HTMLHandler, we can simply add a class to the element
// This function will not replicate the class if already exists
$handler->addClass($element, $class = 'new_class');

// Or add a style (append this to the style attribute)
$handler->style($element, 'color', 'blue');
$handler->style($element, 'font-size', '23px');
```

One of the most important functionalities (and useful) is select(). This function acts like a jQuery selector function, where we can provide a css selector and return the matched items. This function returns a DOMNodeList object and those objects can be manipulated using the handler itself:
```php
use \Panda\Ui\Html\Handlers\HTMLHandler;

$handler = new HTMLHandler();

// We want to find the document title and change the class and the value
$title = $handler->select($element->ownerDocument, $selector = '.web-document .title', $context = null)->item(0);

// Add a new class
$handler->addClass($title, $class = 'blue');

// Set the title
$handler->nodeValue($title, 'This is the document title');
```

HTMLHandler provides a list of HTML-specific functionalities:
* `addClass(DOMElement &$element, $class)`
* `removeClass(DOMElement &$element, $class)`
* `hasClass(DOMElement $element, $class)`
* `style(DOMElement &$element, $name, $val = '')`
* `innerHTML(DOMElement &$element, $value = null, $faultTolerant = true, $convertEncoding = true)`
* `outerHTML(DOMElement $element)`
* `select(DOMDocument $document, $selector, $context = null)`

### HTML Factories

Extending DOM Factory, we have created HTML Factory for HTML-specific functionality and building. The HTML Factory provides an interface for building html elements which would need more than 2 or 3 lines to be built. This factory is being used the same way as the previous factory, in HTMLDocument object. Supported functionality:

* `buildHtmlElement($name = '', $value = '', $id = '', $class = '');`
* `buildWebLink($href = '', $target = '_self', $content = '', $id = '', $class = '');`
* `buildMeta($name = '', $content = '', $httpEquiv = '', $charset = '');`
* `buildLink($rel, $href);`
* `buildScript($src, $async = false);`

```php
use \Panda\Ui\Html\Handlers\HTMLHandler;
use \Panda\Ui\Html\Factories\HTMLFactory;
use \Panda\Ui\Html\HTMLDocument;

// Create a handler instance
$handler = new HTMLHandler();

// Create a new factory instance
$factory = new HTMLFactory();

// Create a document and provide the handler and factory
$document = new HTMLDocument($handler, $factory);


// Get the factory and build an element
$document->getHTMLFactory()->buildElement($name = 'div', $value = 'value', $id = 'id', $class = 'class');

// Document uses the above function with a 'facade' function called create:
$document->create($name = 'div', $value = 'value', $id = 'id', $class = 'class');
```

DOMDocument and HTMLDocument both accept a DOMFactory and an HTMLFactory accordingly so that they can build their elements. The factories are being injected in the constructor, which means that they can be replaced by any DOMFactoryInterface or HTMLFactoryInterface.

### HTML Basics

#### HTMLDocument

Extending basic DOMPrototype, we have created the HTMLDocument object that can be used specifically for HTML pages. It's a base class for easily creating HTML pages, also having access to the HTMLFactory class which provides a lot of functions for creating different html elements.

#### HTMLElement

Now that we have seen the DOMItem and the basic DOM functionality, which extends the native DOMElement functionality, we are introducing the HTMLElement. HTMLElements extend the base DOMItem and offer a new HTML-specific functionality to allow us to create HTML pages, elements and snippets.

The HTML element provides the following functionality as extra and HTML-specific:
* `data($name, $value = []);`
* `addClass($class);`
* `removeClass($class);`
* `hasClass($class);`
* `style($name, $val = '');`
* `innerHTML($value = null, $faultTolerant = true, $convertEncoding = true);`
* `outerHTML();`
* `select($selector, $context = null);`

All the previous functions are using the HTMLHandler that is given in the HTMLDocument that the HTMLElement accepts at the constructor.

```php
use \Panda\Ui\Html\HTMLDocument;
use \Panda\Ui\Html\HTMLElement;

// Create an HTMLDocument
$document = new HTMLDocument(new HTMLHandler(), new HTMLFactory());

// Create an element
$element = new HTMLElement($document, $tag = 'div', $value = '', $id = 'el_id', $class = 'el_class');

// It's easy to add a remove classes
$element->addClass('class_2');
$element->removeClass('el_class');

// We also can add data attribute using json encoding
$data = ['name1' => 'val1', 'name2' => 'val2'];
$element->data('test', $data);

// The previous data() call will generate the following attribute:
// data-test='{"name1":"val1","name2":"val2"}'

// Finally append the element to the document
// As we discussed before, we don't have to do this if we want to append the element directly to the document
$document->append($element);
```

### HTML Forms

#### Platform Generic Form Element

Form builder/factory allows the creation of items with all the appropriate attributes in single-line calls. formItem is an internal object that is being used by the form builder in order to have less, more flexible and smarter code.

#### PHP Examples

```php
// Single-line creator of a form element
	
// Create an HTMLDocument
$document = new HTMLDocument(new HTMLHandler(), new HTMLFactory());

// Create a form element
$fe = new FormElement($document, $itemName = 'select', $name = 'gender', $value = '', $id = '', $class = '', $itemValue = '');

// Append item to anything
$container->append($fe);
```

#### Platform Generic Form Input
Form builder/factory allows the creation of inputs with all the appropriate attributes in single-line calls. FormInput is an internal object that is being used by the form builder in order to have less, more flexible and smarter code.

The FormInput extends the FormElement which minimizes the code even more, allowing the platform to be faster and more efficient. Example:

```php
use \Panda\Ui\Html\HTMLDocument;
use \Panda\Ui\Html\Controls\Form\FormInput;

// Single-line creator of a form input

// Create an HTMLDocument
$document = new HTMLDocument(new HTMLHandler(), new HTMLFactory());

// Create a form input
$fi = new FormInput($document, $type = 'text', $name = 'name', $id = '', $class = '', $value = '', $required = false);

// Append input to form inner container
$container->append($fi);
```

As seen above, we can create input items given the type and the name. Of course, in a form we can use more than inputs (select, textarea etc.) and this is why there is the FormElement object.
