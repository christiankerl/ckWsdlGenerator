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
 * ckWsdlPortType represents a wsdl port type.
 *
 * @package    ckWsdlGenerator
 * @subpackage wsdl
 * @author     Christian Kerl <christian-kerl@web.de>
 */
class ckWsdlPortType implements ckDOMSerializable
{
  /**
   * The name of the root node of the xml representation.
   */
  const ELEMENT_NAME = 'portType';

  /**
   * The name of the port type.
   *
   * @var string
   */
  protected $name;

  /**
   * An array containing all operations of this port type.
   *
   * @var array
   */
  protected $operations = array();

  /**
   * Gets the name of the port type.
   *
   * @return string The name of the port type
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * Sets the name of the port type.
   *
   * @param string $value The name of the port type
   */
  public function setName($value)
  {
    $this->name = $value;
  }

  /**
   * Adds an operation to the port type.
   *
   * @param ckWsdlOperation $operation An operation
   */
  public function addOperation(ckWsdlOperation $operation)
  {
      $this->operations[] = $operation;
  }

  /**
   * Gets an array containing all operations of this port type.
   *
   * @return array An array containing all operations of this port type
   */
  public function getOperations()
  {
    return $this->operations;
  }

  /**
   * @see ckDOMSerializable::getNodeName()
   */
  public function getNodeName()
  {
    return self::ELEMENT_NAME;
  }

  /**
   * @see ckDOMSerializable::serialize()
   */
  public function serialize(DOMDocument $document)
  {
    $wsdl = ckXsdNamespace::get('wsdl');

    $node = $document->createElementNS($wsdl->getUrl(), $wsdl->qualify($this->getNodeName()));

    $node->setAttribute('name', $this->getName());

    foreach($this->getOperations() as $operation)
    {
      $node->appendChild($operation->serialize($document));
    }

    return $node;
  }
}