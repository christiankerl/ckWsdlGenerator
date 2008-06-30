<?php

class ckWsdlMessage implements ISerializable
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