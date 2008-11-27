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
   * @see ckAbstractPropertyStrategy::__construct()
   */
  public function __construct(ReflectionClass $class)
  {
    parent::__construct($class);
  }

  /**
   * @see ckAbstractPropertyStrategy::getProperties()
   */
  public function getProperties()
  {
    $properties = array();

    foreach($this->getClass()->getProperties() as $property)
    {
      $type = ckDocBlockParser::parseProperty($property->getDocComment());

      if(isset($type['type']))
      {
        $properties[] = array('name' => $property->getName(), 'type' => $type['type']);
      }
    }

    return $properties;
  }
}