<?php

abstract class ckWsdlBindingDecorator implements ISerializable
{
  protected $operation = null;
  
  /**
   * Enter description here...
   *
   * @return ckWsdlOperation
   */
  public function getOperation()
  {
    return $this->operation;
  }
  
  /**
   * Enter description here...
   *
   * @param ckWsdlOperation $value
   */
  public function setOperation(ckWsdlOperation $value)
  {
    $this->operation = $value;
  }
  
  public abstract function serialize(DOMDocument $document);
}

?>