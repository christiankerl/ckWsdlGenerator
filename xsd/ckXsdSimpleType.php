<?php

ckXsdSimpleType::create('int');
ckXsdSimpleType::create('string');
ckXsdSimpleType::create('float');

class ckXsdSimpleType extends ckXsdType
{
  public static function create($typeName)
  {
    $type = new ckXsdSimpleType();
    $type->setName($typeName);
    $type->setNamespace(ckXsdNamespace::get('xsd'));
    
    self::set($typeName, $type);
    
    return $type;
  }
  
  protected function __construct()
  {
    parent::__construct();
  }
  
  public function serialize(DOMDocument $document)
  {
    return null;
  }
}

?>