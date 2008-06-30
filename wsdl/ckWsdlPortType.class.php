<?php
/**
 * This file is part of the ckWebServicePlugin
 *
 * @package   ckWsdlGenerator
 * @author    Christian Kerl <christian-kerl@web.de>
 * @copyright Copyright (c) 2008, Christian Kerl
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @version   SVN: $Id: ckSoapHandler.class.php 8064 2008-03-24 16:51:45Z chrisk $
 */

/**
 * Enter description here...
 *
 * @package    ckWsdlGenerator
 * @subpackage wsdl
 * @author     Christian Kerl <christian-kerl@web.de>
 */
class ckWsdlPortType implements ISerializable
{
  const ELEMENT_NAME = 'portType';
  
  protected $name;
  protected $operations = array();
  
  public function getName()
  {
    return $this->name;
  }
  
  public function setName($value)
  {
    $this->name = $value;
  }
  
  public function addOperation(ckWsdlOperation $operation)
  {
    $this->operations[] = $operation;
  }
  
  public function getOperations()
  {
    return $this->operations;
  }
  
  public function serialize(DOMDocument $document)
  {
    $wsdl = ckXsdNamespace::get('wsdl');
    
    $node = $document->createElementNS($wsdl->getUrl(), $wsdl->qualify(self::ELEMENT_NAME));
    
    $node->setAttribute('name', $this->getName());
    
    foreach($this->getOperations() as $operation)
    {
      $node->appendChild($operation->serialize($document));
    }
    
    return $node;
  }
}