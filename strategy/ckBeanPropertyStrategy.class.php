<?php
/**
 * This file is part of the ckWsdlGenerator
 *
 * @package   ckWebServicePlugin
 * @author    Christian Kerl <christian-kerl@web.de>
 * @copyright Copyright (c) 2008, Christian Kerl
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @version   SVN: $Id$
 */

/**
 * ckBeanPropertyStrategy is an implementation of ckAbstractPropertyStrategy,
 * which allows to access properties through getter and setter methods.
 *
 * @package    ckWsdlGenerator
 * @subpackage strategy
 * @author     Christian Kerl <christian-kerl@web.de>
 */
class ckBeanPropertyStrategy extends ckAbstractPropertyStrategy
{
  /**
   * (non-PHPdoc)
   * @see strategy/ckAbstractPropertyStrategy#__construct()
   */
  public function __construct(ReflectionClass $class)
  {
    parent::__construct($class);
  }

  /**
   * (non-PHPdoc)
   * @see strategy/ckAbstractPropertyStrategy#getProperties()
   */
  public function getProperties()
  {
    $properties = array();

    foreach($this->getClass()->getMethods() as $method)
    {
      if(!$method->isPublic() || $method->isStatic() || !$this->isGetterName($method->getName()))
      {
        continue;
      }

      $return = ckDocBlockParser::parseReturn($method->getDocComment());

      if(empty($return))
      {
        continue;
      }

      $properties[] = array('name' => $this->getPropertyName($method->getName()), 'type' => $return['type']);
    }

    return $properties;
  }

  /**
   * (non-PHPdoc)
   * @see strategy/ckAbstractPropertyStrategy#getPropertyValue()
   */
  public function getPropertyValue($object, $property)
  {
    $callback = array($object, $this->getGetterName($property));

    if(!$this->getClass()->isInstance($object) || !is_callable($callback))
    {
      throw new InvalidArgumentException();
    }

    return call_user_func($callback);
  }

  /**
   * (non-PHPdoc)
   * @see strategy/ckAbstractPropertyStrategy#setPropertyValue()
   */
  public function setPropertyValue($object, $property, $value)
  {
    $callback = array($object, $this->getSetterName($property));

    if(!$this->getClass()->isInstance($object) || !is_callable($callback))
    {
      throw new InvalidArgumentException();
    }

    call_user_func($callback, $value);
  }

  /**
   * Gets the getter method name for a given property name.
   *
   * @param string $property A property name
   *
   * @return string The getter method name
   */
  protected function getGetterName($property)
  {
    return 'get'.ckString::ucfirst($property);
  }

  /**
   * Gets the setter method name for a given property name.
   *
   * @param string $property A property name
   *
   * @return string The setter method name
   */
  protected function getSetterName($property)
  {
    return 'set'.ckString::ucfirst($property);
  }

  /**
   * Gets the property name for a given getter or setter method name.
   *
   * @param string $name A getter or setter method name
   *
   * @return string The property name
   */
  protected function getPropertyName($name)
  {
    if(ckString::startsWith($name, 'get') || ckString::startsWith($name, 'set'))
    {
      return ckString::lcfirst(substr($name, 3));
    }
  }

  /**
   * Checks if a given method name identifies a getter method.
   *
   * @param string $name A method name
   *
   * @return bool True, if the method name identifies a getter method, false otherwise
   */
  protected function isGetterName($name)
  {
    return ckString::startsWith($name, 'get') && strlen($name) > 3;
  }
}