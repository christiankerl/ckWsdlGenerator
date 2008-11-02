<?php
/**
 * This file is part of the ckWsdlGenerator
 *
 * @package   ckWsdlGenerator
 * @author    Christian Kerl <christian-kerl@web.de>
 * @copyright Copyright (c) 2008, Christian Kerl
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @version   SVN: $Id$
 */

/**
 * ckWsdlBindingDecorator provides a base class with common methods for all specific binding decorators,
 * which add transfer protocol specific data to wsdl bindings.
 *
 * @package    ckWsdlGenerator
 * @subpackage wsdl
 * @author     Christian Kerl <christian-kerl@web.de>
 */
abstract class ckWsdlBindingDecorator implements ckDOMSerializable
{
  /**
   * The name of the root node of the xml representation.
   */
  const ELEMENT_NAME = 'binding';

  /**
   * The name of the binding.
   *
   * @var string
   */
  protected $name;

  /**
   * The port type corresponding to the binding.
   *
   * @var ckWsdlPortType
   */
  protected $portType = null;

  /**
   * Gets the name of the binding.
   *
   * @return string The name of the binding
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * Sets the name of the binding
   *
   * @param string $value The name of the binding
   */
  public function setName($value)
  {
    $this->name = $value;
  }

  /**
   * Gets the port type corresponding to the binding.
   *
   * @return ckWsdlPortType The port type corresponding to the binding
   */
  public function getPortType()
  {
    return $this->portType;
  }

  /**
   * Sets the port type corresponding to the binding.
   *
   * @param ckWsdlPortType $value The port type corresponding to the binding
   */
  public function setPortType(ckWsdlPortType $value)
  {
    $this->portType = $value;
  }

  /**
   * @see ckDOMSerializable::getNodeName()
   */
  public function getNodeName()
  {
    return self::ELEMENT_NAME;
  }
}