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
 * ckWsdlService represents a wsdl service.
 *
 * @package    ckWsdlGenerator
 * @subpackage wsdl
 * @author     Christian Kerl <christian-kerl@web.de>
 */
class ckWsdlService implements ckDOMSerializable
{
  /**
   * The name of the root node of the xml representation.
   */
  const ELEMENT_NAME = 'service';

  /**
   * The name of the service.
   *
   * @var string
   */
  protected $name;

  /**
   * An array containing all ports of the service.
   *
   * @var array
   */
  protected $ports = array();

  /**
   * Gets the name of the service.
   *
   * @return string The name of the service
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * Sets the name of the service.
   *
   * @param string $value The name of the service
   */
  public function setName($value)
  {
    $this->name = $value;
  }

  /**
   * Gets an array containing all ports of the service.
   *
   * @return ckWsdlPortDecorator An array containing all ports of the service
   */
  public function getPorts()
  {
    return $this->port;
  }

  /**
   * Adds a port to the service.
   *
   * @param ckWsdlPortDecorator $value A port to add
   */
  public function addPort(ckWsdlPortDecorator $value)
  {
    $this->port[] = $value;
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

    foreach($this->getPorts() as $port)
    {
      $node->appendChild($port->serialize($document));
    }

    return $node;
  }
}