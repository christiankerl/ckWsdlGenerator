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
 * ckXsdArrayType represents an array type of a simple or a complex xsd type.
 *
 * @package    ckWsdlGenerator
 * @subpackage xsd
 * @author     Christian Kerl <christian-kerl@web.de>
 */
class ckXsdArrayType extends ckXsdComplexType
{
  /**
   * The suffix of a type name, which identifies it as array type.
   */
  const ARRAY_SUFFIX = '[]';

  /**
   * The prefix every array type name starts with.
   */
  const NAME_SUFFIX = 'Array';

  /**
   * Creates a new array type object, if the given type name is one of an array type.
   *
   * @param string $name The name of an array type
   *
   * @return ckXsdArrayType The array type object
   */
  public static function create($name)
  {
    if(self::isArrayType($name))
    {
      $elementTypeName = substr($name, 0, -strlen(self::ARRAY_SUFFIX));
      $elementType = ckXsdType::get($elementTypeName);

      if(!is_null($elementType))
      {
        return new ckXsdArrayType(ckString::ucfirst($elementTypeName).self::NAME_SUFFIX, ckXsdNamespace::get('tns'), $elementType);
      }
    }

    return null;
  }

  /**
   * Checks wether the given type is an array type.
   *
   * @param string $name A type name
   *
   * @return boolean True, if the given type is an array type, false otherwise
   */
  public static function isArrayType($name)
  {
    return ckString::endsWith($name, self::ARRAY_SUFFIX);
  }

  /**
   * The xsd type of the elements of the array.
   *
   * @var ckXsdType
   */
  protected $elementType;

  /**
   * Sets the xsd type of the elements of the array.
   *
   * @param ckXsdType $value The xsd type of the elements of the array
   */
  public function setElementType(ckXsdType $value)
  {
    $this->elementType = $value;
  }

  /**
   * Gets the xsd type of the elements of the array.
   *
   * @return ckXsdType The xsd type of the elements of the array
   */
  public function getElementType()
  {
    return $this->elementType;
  }

  /**
   * @see ckXsdComplexType::getElements()
   */
  public function getElements()
  {
    return array(new ckXsdComplexTypeElement('item', $this->getElementType(), '0', 'unbound'));
  }

  /**
   * Hides ckXsdComplexType::addElement(), does nothing.
   *
   * @see ckXsdComplexType::addElement()
   */
  public function addElement(ckXsdComplexTypeElement $element)
  {
  }

  /**
   * Protected constructor initializing the array type with a given name, a given namespace and a given element type.
   *
   * @param string         $name        The name of the array
   * @param ckXsdNamespace $namespace   The namespace of the array type
   * @param ckXsdType      $elementType The type of the elements of the array
   */
  protected function __construct($name = null, ckXsdNamespace $namespace = null, ckXsdType $elementType = null)
  {
    parent::__construct($name, $namespace);

    $this->setElementType($elementType);
  }
}