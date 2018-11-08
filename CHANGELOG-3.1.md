CHANGELOG for 3.1.x
===================

This changelog references the relevant changes (bug and security fixes) done in all versions (major and minor)

To get the diff for a specific change, go to https://github.com/PandaPlatform/ui/commit/XXX where XXX is the change hash

* 3.1.9 (future-release)

* 3.1.8 (2018-11-08)
  * [Html] Remove character '&' replace functionality from $data['data'] in renderElement

* 3.1.7 (2018-10-18)
  * [Html] HTMLElement::render(): Check for innerHTML() value properly
  * [Html] HTMLElement::render(): Re-order functionality to align
  
* 3.1.6 (2018-10-17)
  * [Html] HTMLElement::render(): Support '&' only for class attributes
  
* 3.1.5 (2018-10-15)
  * [Dom] Add value check for string '0'
  
* 3.1.4 (2018-10-01)
  * [Html] HTMLElement::render(): Support multiple elements by selector.
  * [Html] HTMLElement::render(): Support more actions like append and prepend.
  * [Html] HTMLElement::render(): Support extra attributes for nodeValue and innerHTML.
  
* 3.1.3 (2018-09-26)
  * [Html] Render HTMLElement with a set of given parameters including attributes etc.
  
* 3.1.2 (2018-09-04)
  * Accept attributes when building Dom and Html elements
  
* 3.1.1 (2018-01-13)
  * Update PHPUnit to ~6.3
