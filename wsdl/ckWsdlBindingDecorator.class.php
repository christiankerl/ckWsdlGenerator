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