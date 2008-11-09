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
 * ckXsdSimpleType represents a simple xsd type.
 *
 * @package    ckWsdlGenerator
 * @subpackage xsd
 * @author     Christian Kerl <christian-kerl@web.de>
 */
class ckXsdSimpleType extends ckXsdType
{
  /**
   * An array of all defined simple xsd types, which have a php equivalent.
   *
   * @var array
   */
  protected static $SIMPLE_TYPES = array('boolean', 'int', 'float', 'string', 'anyType');

  /**
   * An array with alternative names for simple xsd types as keys and their corresponding type as values.
   *
   * @var array
   */
  protected static $ALIAS = array('integer' => 'int', 'bool' => 'boolean');

  /**
   * Checks wether the given type is a simple xsd type.
   *
   * @param string $name A type name
   *
   * @return boolean True, if the given type is a simple xsd type, false otherwise
   */
  public static function isSimpleType($name)
  {
    return in_array($name, self::$SIMPLE_TYPES) || isset(self::$ALIAS[$name]);
  }

  /**
   * Creates a new simple xsd type object, if the given name is one of a simple type or an alias.
   *
   * @param string $name The name of the simple xsd type
   *
   * @return ckXsdSimpleType The simple xsd type object
   */
  public static function create($name)
  {
    if(isset(self::$ALIAS[$name]))
    {
      $name = self::$ALIAS[$name];
    }

    return self::isSimpleType($name) ? new ckXsdSimpleType($name) : null;
  }

  /**
   * Protected constructor initializing the simple xsd type with a given name.
   *
   * @param string $name The name of the simple xsd type
   */
  protected function __construct($name = null)
  {
    parent::__construct($name, ckXsdNamespace::get('xsd'));
  }

  /**
   * @see ckDOMSerializable::serialize()
   */
  public function serialize(DOMDocument $document)
  {
    throw new Exception('Not supported.');
  }
}