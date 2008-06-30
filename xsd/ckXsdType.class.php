<?php

abstract class ckXsdType implements ISerializable
{
  protected static $typeRegistry = array();
  
  /**
   * Enter description here...
   *
   * @param string $key
   * @return ckXsdNamespace
   */
  public static function get($key)
  {    
    if(isset(self::$typeRegistry[$key]))
    {
      return self::$typeRegistry[$key];
    }
    else
    {
      return null;
    }
  }
  
  /**
   * Enter description here...
   *
   * @param string $key
   * @param string $url
   * @param string $shortName
   */
  public static function set($key, $type)
  {    
    self::$typeRegistry[$key] = $type;
  }
  
  /**
   * Enter description here...
   *
   * @param string $typeName
   */
  public static abstract function create($typeName);
  
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
  protected $namespace;
  
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
   * @return ckXsdNamespace
   */
  public function getNamespace()
  {
    return $this->namespace;
  }
  
  /**
   * Enter description here...
   *
   * @param ckXsdNamespace $value
   */
  public function setNamespace(ckXsdNamespace $value)
  {
    $this->namespace = $value;
  }
  
  protected function __construct()
  {
    
  }
  
  /**
   * Enter description here...
   *
   * @return string
   */
  public function getQualifiedName()
  {
    return $this->getNamespace()->qualify($this->getName());
  }
  
  public abstract function serialize(DOMDocument $document);
}