<?php

class ckWsdlPart implements ISerializable
{
  const ELEMENT_NAME = 'part';
  
  protected $name;
  protected $type;
  
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
  
  public function __construct($name = null, ckXsdType $type = null)
  {
    $this->setName($name);
    $this->setType($name);
  }
  
  public function serialize(DOMDocument $document)
  {
    $wsdl = ckXsdNamespace::get('wsdl');
    
    $node = $document->createElementNS($wsdl->getUrl(),$wsdl->qualify(self::ELEMENT_NAME));
    
    $node->setAttribute('name', $this->getName());
    $node->setAttribute('type', $this->getType()->getQualifiedName());
    
    return $node;
  }
  
  public function __toString()
  {
    return $this->getName();
  }
}