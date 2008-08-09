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
abstract class ckWsdlPortDecorator implements ckDOMSerializable
{
  const ELEMENT_NAME = 'port';

  protected $name;
  protected $location;
  protected $binding = null;

  public function getName()
  {
    return $this->name;
  }

  public function setName($value)
  {
    $this->name = $value;
  }

  public function getLocation()
  {
    return $this->location;
  }

  public function setLocation($value)
  {
    $this->location = $value;
  }

  /**
   * Enter description here...
   *
   * @return ckWsdlBindingDecorator
   */
  public function getBinding()
  {
    return $this->binding;
  }

  /**
   * Enter description here...
   *
   * @param ckWsdlBindingDecorator $value
   */
  public function setBinding(ckWsdlBindingDecorator $value)
  {
    $this->binding = $value;
  }

  public function getNodeName()
  {
    return self::ELEMENT_NAME;
  }

  //public abstract function serialize(DOMDocument $document);
}