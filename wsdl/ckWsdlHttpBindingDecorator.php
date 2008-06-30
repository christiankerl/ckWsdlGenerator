<?php

class ckWsdlHttpBindingDecorator extends ckWsdlBindingDecorator
{
  public abstract function serialize(DOMDocument $document)
  {
    return $this->getOperation()->serialize($document);
  }
}

?>