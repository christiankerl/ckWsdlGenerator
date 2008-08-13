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
 * @subpackage wsdl
 * @author     Christian Kerl <christian-kerl@web.de>
 */
class ckWsdlPart implements ckDOMSerializable
{
  const ELEMENT_NAME = 'part';

  protected $name;
  protected $type;
  protected $isHeader;

  public function getName()
  {
    return $this->name;
  }

  public function setName($value)
  {
    $this->name = $value;
  }

  public function getType()
  {
    return $this->type;
  }

  public function setType(ckXsdType $value)
  {
    $this->type = $value;
  }

  public function getIsHeader()
  {
    return $this->isHeader;
  }

  public function setIsHeader($value)
  {
    $this->isHeader = $value;
  }

  public function getNodeName()
  {
    return self::ELEMENT_NAME;
  }

  public function __construct($name = null, ckXsdType $type = null, $isHeader = false)
  {
    $this->setName($name);
    $this->setType($type);
    $this->setIsHeader($isHeader);
  }

  public function serialize(DOMDocument $document)
  {
    $wsdl = ckXsdNamespace::get('wsdl');

    $node = $document->createElementNS($wsdl->getUrl(),$wsdl->qualify($this->getNodeName()));

    $node->setAttribute('name', $this->getName());
    $node->setAttribute('type', $this->getType()->getQualifiedName());

    return $node;
  }

  public function __toString()
  {
    return $this->getName();
  }
}