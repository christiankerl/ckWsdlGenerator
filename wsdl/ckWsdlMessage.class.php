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
class ckWsdlMessage implements ckDOMSerializable
{
  const ELEMENT_NAME = 'message';
  
  protected $name;
  protected $parts = array();
  
  public function getName()
  {
    return $this->name;
  }
  
  public function setName($value)
  {
    $this->name = $value;
  }
  
  public function getParts()
  {
    return $this->parts;
  }
  
  public function addPart(ckWsdlPart $part)
  {
    $this->parts[] = $part;
  }  
  
  public function __construct($name)
  {
    $this->setName($name);
  }
  
  public function serialize(DOMDocument $document)
  {
    $wsdl = ckXsdNamespace::get('wsdl');
    
    $node = $document->createElementNS($wsdl->getUrl(), $wsdl->qualify(self::ELEMENT_NAME));
    
    $node->setAttribute('name', $this->getName());
    
    foreach($this->getParts() as $part)
    {
      $node->appendChild($part->serialize($document));
    }
    
    return $node;
  }
}