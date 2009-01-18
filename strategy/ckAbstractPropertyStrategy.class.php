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
 * ckAbstractPropertyStrategy provides a common interface for all property strategies,
 * which are used to get all properties of a class, which should be included in xsd schema
 * and provide sufficient type information.
 *
 * @package    ckWsdlGenerator
 * @subpackage strategy
 * @author     Christian Kerl <christian-kerl@web.de>
 */
abstract class ckAbstractPropertyStrategy
{
  /**
   * Gets the ckAbstractPropertyStrategy implementation for a given class from the PropertyStrategy annotation,
   * if no annotation is found ckDefaultPropertyStrategy is returned.
   *
   * @param ReflectionAnnotatedClass $class A ReflectionAnnotatedClass object
   *
   * @return ckAbstractPropertyStrategy The ckAbstractPropertyStrategy implementation
   */
  public static function getPropertyStrategy(ReflectionAnnotatedClass $class)
  {
    $strategy = null;

    if($class->hasAnnotation('PropertyStrategy'))
    {
      $strategy = $class->getAnnotation('PropertyStrategy')->value;

      $strategy = new $strategy($class);
    }
    if(is_null($strategy) || !$strategy instanceof ckAbstractPropertyStrategy)
    {
      $strategy = new ckDefaultPropertyStrategy($class);
    }

    return $strategy;
  }

  /**
   * The associated ReflectionClass.
   *
   * @var ReflectionClass
   */
  protected $class;

  /**
   * Gets the associated ReflectionClass.
   *
   * @return ReflectionClass A ReflectionClass object
   */
  public function getClass()
  {
    return $this->class;
  }

  /**
   * Constructor initializing the strategy with a given ReflectionClass.
   *
   * @param ReflectionClass $class A ReflectionClass object
   */
  public function __construct(ReflectionClass $class)
  {
    $this->class = $class;
  }

  /**
   * Gets all properties, which should be included in the xsd schema and which provide sufficient type information.
   *
   * @return array An array which contains foreach property an array with a 'name' and a 'type' entry
   */
  public abstract function getProperties();

  /**
   * Gets the value of a given property from a given object.
   *
   * @param object $object   An object
   * @param string $property The property name
   *
   * @return mixed The value of the property
   */
  public abstract function getPropertyValue($object, $property);

  /**
   * Sets the value of a given property on a given object.
   *
   * @param object $object   An object
   * @param string $property The property name
   * @param mixed  $value    The value
   */
  public abstract function setPropertyValue($object, $property, $value);
}