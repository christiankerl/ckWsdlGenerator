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
 * ckXsdType is the base class for all representations of xsd types and provides a central xsd type registry.
 *
 * @package    ckWsdlGenerator
 * @subpackage xsd
 * @author     Christian Kerl <christian-kerl@web.de>
 */
abstract class ckXsdType implements ckDOMSerializable
{
  /**
   * An array containing all registered xsd types.
   *
   * @var array
   */
  protected static $typeRegistry = array();

  /**
   * Gets a xsd type with a given name from the registry or creates and registers a new one if none exists.
   *
   * @param string $typeName The name of the xsd type
   *
   * @return ckXsdType The xsd type object, or null if none exists or can be created
   */
  public static function get($typeName)
  {
    if(isset(self::$typeRegistry[$typeName]))
    {
      return self::$typeRegistry[$typeName];
    }
    else if(ckXsdSimpleType::isSimpleType($typeName))
    {
      return self::set($typeName, ckXsdSimpleType::create($typeName));
    }
    else if($typeName == 'array')
    {
      return self::set($typeName, ckXsdArrayType::create('anyType'.ckXsdArrayType::ARRAY_SUFFIX));
    }
    else if(ckXsdArrayType::isArrayType($typeName))
    {
      return self::set($typeName, ckXsdArrayType::create($typeName));
    }
    else if(class_exists($typeName, true))
    {
      return self::set($typeName, ckXsdComplexType::create($typeName));
    }
    else
    {
      return null;
    }
  }

  /**
   * Gets all registered xsd types.
   *
   * @return array An array containing all registered xsd types
   */
  public static function getAll()
  {
    return self::$typeRegistry;
  }

  /**
   * Gets all registered complex and array types.
   *
   * @return array An array containing all registered complex and array types
   */
  public static function getComplexAndArrayTypes()
  {
    return array_filter(ckXsdType::getAll(), array(__CLASS__, 'isComplexOrArrayType'));
  }

  /**
   * Adds a given xsd type with a given name to the registry.
   *
   * @param string    $name The type name
   * @param ckXsdType $type A xsd type to add
   *
   * @return ckXsdType The given xsd type
   */
  public static function set($name, ckXsdType $type = null)
  {
    self::$typeRegistry[$name] = $type;

    return $type;
  }

  /**
   * Checks wether the given xsd type is a complex or array type.
   *
   * @param ckXsdType $input A type to check
   *
   * @return boolean True, if the given type is a complex or array type, false otherwise
   */
  private static function isComplexOrArrayType($input)
  {
    return $input instanceof ckXsdComplexType || $input instanceof ckXsdArrayType;
  }

  /**
   * The name of the type.
   *
   * @var string
   */
  protected $name;

  /**
   * The namespace of the type.
   *
   * @var ckXsdNamespace
   */
  protected $namespace;

  /**
   * Gets the name of the type.
   *
   * @return string The name of the type
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * Sets the name of the type.
   *
   * @param string $value The name of the type.
   */
  public function setName($value)
  {
    $this->name = $value;
  }

  /**
   * Gets the namespace of the type.
   *
   * @return ckXsdNamespace The namespace of the type
   */
  public function getNamespace()
  {
    return $this->namespace;
  }

  /**
   * Sets the namespace of the type.
   *
   * @param ckXsdNamespace $value The namespace of the type
   */
  public function setNamespace(ckXsdNamespace $value)
  {
    $this->namespace = $value;
  }

  /**
   * Gets the qualified name of the type.
   *
   * @return string The qualified name of the type
   */
  public function getQualifiedName()
  {
    return $this->getNamespace()->qualify($this->getName());
  }

  /**
   * @see ckDOMSerializable::getNodeName()
   */
  public function getNodeName()
  {
    return '';
  }

  /**
   * Protected constructor initializing the type with a given name and namespace.
   *
   * @param string         $name      The name of the type
   * @param ckXsdNamespace $namespace The namespace of the type
   */
  protected function __construct($name = null, ckXsdNamespace $namespace = null)
  {
    $this->setName($name);
    $this->setNamespace($namespace);
  }
}