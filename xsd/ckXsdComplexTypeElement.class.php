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
class ckXsdComplexTypeElement implements ckDOMSerializable
{
  const ELEMENT_NAME = 'element';

  /**
   * Enter description here...
   *
   * @var string
   */
  protected $name;

  /**
   * Enter description here...
   *
   * @var ckXsdNamespace
   */
  protected $type;

  /**
   * Enter description here...
   *
   * @return string
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * Enter description here...
   *
   * @param string $value
   */
  public function setName($value)
  {
    $this->name = $value;
  }

  /**
   * Enter description here...
   *
   * @return ckXsdType
   */
  public function getType()
  {
    return $this->type;
  }

  /**
   * Enter description here...
   *
   * @param ckXsdType $value
   */
  public function setType(ckXsdType $value)
  {
    $this->type = $value;
  }

  public function getNodeName()
  {
    return self::ELEMENT_NAME;
  }

  public function __construct($name, ckXsdType $type)
  {
    $this->setName($name);
    $this->setType($type);
  }

  public function serialize(DOMDocument $document)
  {
    $xsd = ckXsdNamespace::get('xsd');

    $node = $document->createElementNS($xsd->getUrl(), $xsd->qualify($this->getNodeName()));
    $node->setAttribute('name', $this->getName());
    $node->setAttribute('type', $this->getType()->getQualifiedName());

    return $node;
  }
}