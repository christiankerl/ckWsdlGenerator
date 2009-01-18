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
 * ckDefaultPropertyStrategy is the default implementation of ckAbstractPropertyStrategy.
 *
 * @package    ckWsdlGenerator
 * @subpackage strategy
 * @author     Christian Kerl <christian-kerl@web.de>
 */
class ckDefaultPropertyStrategy extends ckAbstractPropertyStrategy
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

    foreach($this->getClass()->getProperties() as $property)
    {
      if(!$property->isPublic() || $property->isStatic())
      {
        continue;
      }

      $type = ckDocBlockParser::parseProperty($property->getDocComment());

      if(isset($type['type']))
      {
        $properties[] = array('name' => $property->getName(), 'type' => $type['type']);
      }
    }

    return $properties;
  }

  /**
   * (non-PHPdoc)
   * @see strategy/ckAbstractPropertyStrategy#getPropertyValue()
   */
  public function getPropertyValue($object, $property)
  {
    if(!$this->getClass()->isInstance($object) || !$this->getClass()->hasProperty($property))
    {
      throw new InvalidArgumentException();
    }

    return $this->getClass()->getProperty($property)->getValue($object);
  }

  /**
   * (non-PHPdoc)
   * @see strategy/ckAbstractPropertyStrategy#setPropertyValue()
   */
  public function setPropertyValue($object, $property, $value)
  {
    if(!$this->getClass()->isInstance($object) || !$this->getClass()->hasProperty($property))
    {
      throw new InvalidArgumentException();
    }

    $this->getClass()->getProperty($property)->setValue($object, $value);
  }
}