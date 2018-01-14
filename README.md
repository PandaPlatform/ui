# Panda Ui Package

This is the Panda Ui Package

[![StyleCI](https://styleci.io/repos/55763384/shield?branch=3.1)](https://styleci.io/repos/55763384/shield?branch=3.1)
[![Latest Stable Version](https://poser.pugx.org/panda/ui/v/stable?format=flat-square)](https://packagist.org/packages/panda/ui)
[![Total Downloads](https://poser.pugx.org/panda/ui/downloads?format=flat-square)](https://packagist.org/packages/panda/ui)
[![License](https://poser.pugx.org/panda/ui/license?format=flat-square)](https://packagist.org/packages/panda/ui)

- [Introduction](#introduction)
- [Installation](#installation)
  - [Through the composer](#through-the-composer)

## Introduction
Panda Ui component is a backend ui handler/renderer engine that enables generating html (including xml) content in a more structured way.

This component is extending the normal DOM structure that is offered by the language itself, including some of the following classes:
- [`DOMNode`](http://php.net/manual/en/class.domnode.php)
- [`DOMDocument`](http://php.net/manual/en/class.domdocument.php)
- [`DOMElement`](http://php.net/manual/en/class.domelement.php)

This is the main reason why this component is so powerful, providing extra, faster and more clever functionality using existing components.

This package is able to create html pages using the DOM structure fast and easy. Some of the features include:

* Dom manipulation from PHP
* Dom Factory that creates Dom Elements
* Html specific controls and manipulation
* Html controls ready to be used
* Backend Html parsing and selecting using css selectors
* Form factories and builders
* Generic components

## Installation

### Through the composer

Add the following line to your `composer.json` file:

```
"panda/ui": "^3.1"
```

## Packages

For extending reading on how to use the `DOM` and `Html` Packages, refer to their readme files:
- [DOM Package](Dom/README.md)
- [HTML Package](Html/README.md)
