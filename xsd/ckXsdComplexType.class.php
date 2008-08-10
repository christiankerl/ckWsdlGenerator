<?php
/**
 * This file is part of the ckWebServicePlugin
 *
 * @package   ckWsdlGenerator
 * @author    Christian Kerl <christian-kerl@web.de>
 * @copyright Copyright (c) 2008, Christian Kerl
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @version   SVN: $Id$
 */

/**
 * Enter description here...
 *
 * @package    ckWsdlGenerator
 * @subpackage xsd
 * @author     Christian Kerl <christian-kerl@web.de>
 */
class ckXsdComplexType extends ckXsdType
{
  const ELEMENT_NAME = 'complexType';

  public static function create($name)
  {
    $reflectClass= new ReflectionClass($name);
    $result = new ckXsdComplexType($name, ckXsdNamespace::get('tns'));

    foreach($reflectClass->getProperties() as $property)
    {
      $type = ckDocBlockParser::parseProperty($property->getDocComment());
      $result->addElement(new ckXsdComplexTypeElement($property->getName(), ckXsdType::get($type['type'])));
    }

    return $result;
  }

  protected $elements = array();

  /**
   * Enter description here...
   *
   * @param ckXsdComplexTypeElement $element
   */
  public function addElement(ckXsdComplexTypeElement $element)
  {
    $this->elements[] = $element;
  }

  /**
   * Enter description here...
   *
   * @return array
   */
  public function getElements()
  {
    return $this->elements;
  }

  public function getNodeName()
  {
    return self::ELEMENT_NAME;
  }

  protected function __construct($name = null, ckXsdNamespace $namespace = null)
  {
    parent::__construct($name, $namespace);
  }

  public function serialize(DOMDocument $document)
  {
    $xsd = ckXsdNamespace::get('xsd');

    $node = $document->createElementNS($xsd->getUrl(), $xsd->qualify($this->getNodeName()));
    $node->setAttribute('name', $this->getName());

    $sequence = $document->createElementNS($xsd->getUrl(), $xsd->qualify('sequence'));

    foreach($this->getElements() as $element)
    {
      $sequence->appendChild($element->serialize($document));
    }

    $node->appendChild($sequence);

    return $node;
  }
}