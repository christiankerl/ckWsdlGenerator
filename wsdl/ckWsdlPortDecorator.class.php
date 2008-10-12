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
 * ckWsdlPortDecorator provides a base class with common methods for all specific port decorators,
 * which add transfer protocol specific data to wsdl ports.
 *
 * @package    ckWsdlGenerator
 * @subpackage wsdl
 * @author     Christian Kerl <christian-kerl@web.de>
 */
abstract class ckWsdlPortDecorator implements ckDOMSerializable
{
  /**
   * The name of the root node of the xml representation.
   */
  const ELEMENT_NAME = 'port';

  /**
   * The name of the port.
   *
   * @var string
   */
  protected $name;

  /**
   * The endpoint location of the port.
   *
   * @var string
   */
  protected $location;

  /**
   * The binding corresponding to the port.
   *
   * @var ckWsdlBindingDecorator
   */
  protected $binding = null;

  /**
   * Gets the name of the port.
   *
   * @return string The name of the port
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * Sets the name of the port.
   *
   * @param string $value The name of the port
   */
  public function setName($value)
  {
    $this->name = $value;
  }

  /**
   * Gets the endpoint location of the port.
   *
   * @return string The endpoint location of the port.
   */
  public function getLocation()
  {
    return $this->location;
  }

  /**
   * Sets the endpoint location of the port.
   *
   * @param string $value The endpoint location of the port
   */
  public function setLocation($value)
  {
    $this->location = $value;
  }

  /**
   * Gets the binding corresponding to the port.
   *
   * @return ckWsdlBindingDecorator The binding corresponding to the port
   */
  public function getBinding()
  {
    return $this->binding;
  }

  /**
   * Sets the binding corresponding to the port.
   *
   * @param ckWsdlBindingDecorator $value The binding corresponding to the port
   */
  public function setBinding(ckWsdlBindingDecorator $value)
  {
    $this->binding = $value;
  }

  /**
   * @see ckDOMSerializable::getNodeName()
   */
  public function getNodeName()
  {
    return self::ELEMENT_NAME;
  }
}