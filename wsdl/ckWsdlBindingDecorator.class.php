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
abstract class ckWsdlBindingDecorator implements ckDOMSerializable
{
  const ELEMENT_NAME = 'binding';
  
  protected $name;
  protected $portType = null;  
  
  public function getName()
  {
    return $this->name;
  }
  
  public function setName($value)
  {
    $this->name = $value;
  }
  
  /**
   * Enter description here...
   *
   * @return ckWsdlPortType
   */
  public function getPortType()
  {
    return $this->portType;
  }
  
  /**
   * Enter description here...
   *
   * @param ckWsdlPortType $value
   */
  public function setPortType(ckWsdlPortType $value)
  {
    $this->portType = $value;
  }
  
  public abstract function serialize(DOMDocument $document);
}