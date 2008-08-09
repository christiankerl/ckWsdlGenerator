<?php
/**
 * This file is part of the ckWebServicePlugin
 *
 * @package   ckWsdlGenerator
 * @author    Christian Kerl <christian-kerl@web.de>
 * @copyright Copyright (c) 2008, Christian Kerl
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @version   SVN: $Id$
 */

/**
 * Enter description here...
 *
 * @package    ckWsdlGenerator
 * @subpackage wsdl
 * @author     Christian Kerl <christian-kerl@web.de>
 */
class ckWsdlService implements ckDOMSerializable
{
  const ELEMENT_NAME = 'service';

  protected $name;
  protected $ports = array();

  public function getName()
  {
    return $this->name;
  }

  public function setName($value)
  {
    $this->name = $value;
  }

  /**
   * Enter description here...
   *
   * @return ckWsdlPortDecorator
   */
  public function getPorts()
  {
    return $this->port;
  }

  /**
   * Enter description here...
   *
   * @param ckWsdlPortDecorator $value
   */
  public function addPort(ckWsdlPortDecorator $value)
  {
    $this->port[] = $value;
  }

  public function getNodeName()
  {
    return self::ELEMENT_NAME;
  }

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