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
 * ckXsdComplexTypeElement represents a xsd element.
 *
 * @package    ckWsdlGenerator
 * @subpackage xsd
 * @author     Christian Kerl <christian-kerl@web.de>
 */
class ckXsdComplexTypeElement implements ckDOMSerializable
{
  /**
   * The name of the root node of the xml representation.
   */
  const ELEMENT_NAME = 'element';

  /**
   * The name of the element.
   *
   * @var string
   */
  protected $name;

  /**
   * The type of the element.
   *
   * @var ckXsdType
   */
  protected $type;

  /**
   * Gets the name of the element.
   *
   * @return string The name of the element
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * Sets the name of the element.
   *
   * @param string $value The name of the element
   */
  public function setName($value)
  {
    $this->name = $value;
  }

  /**
   * Gets the type of the element.
   *
   * @return ckXsdType The type of the element
   */
  public function getType()
  {
    return $this->type;
  }

  /**
   * Sets the type of the element.
   *
   * @param ckXsdType $value The type of the element
   */
  public function setType(ckXsdType $value)
  {
    $this->type = $value;
  }

  /**
   * @see ckDOMSerializable::getNodeName()
   */
  public function getNodeName()
  {
    return self::ELEMENT_NAME;
  }

  /**
   * Constructor initializing the element with a given name and a given type.
   *
   * @param string    $name The name of the element
   * @param ckXsdType $type The type of the element
   */
  public function __construct($name, ckXsdType $type)
  {
    $this->setName($name);
    $this->setType($type);
  }

  /**
   * @see ckDOMSerializable::serialize()
   */
  public function serialize(DOMDocument $document)
  {
    $xsd = ckXsdNamespace::get('xsd');

    $node = $document->createElementNS($xsd->getUrl(), $xsd->qualify($this->getNodeName()));
    $node->setAttribute('name', $this->getName());
    $node->setAttribute('type', $this->getType()->getQualifiedName());

    return $node;
  }
}