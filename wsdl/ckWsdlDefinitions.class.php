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
class ckWsdlDefinitions implements ckDOMSerializable
{
  const ELEMENT_NAME = 'definitions';

  protected $types = array();
  protected $portTypes = array();
  protected $bindings = array();
  protected $messages = array();
  protected $services = array();

  public function addType(ckXsdType $value)
  {
    $this->types[] = $value;
  }

  public function getTypes()
  {
    return $this->types;
  }

  public function addPortType(ckWsdlPortType $value)
  {
    $this->portTypes[] = $value;
  }

  public function getPortTypes()
  {
    return $this->portTypes;
  }

  public function addBinding(ckWsdlBindingDecorator $value)
  {
    $this->bindings[] = $value;
  }

  public function getBindings()
  {
    return $this->bindings;
  }

  public function addMessage(ckWsdlMessage $value)
  {
    $this->messages[] = $value;
  }

  public function getMessages()
  {
    return $this->messages;
  }

  public function addService(ckWsdlService $value)
  {
    $this->services[] = $value;
  }

  public function getServices()
  {
    return $this->services;
  }

  public function getNodeName()
  {
    return self::ELEMENT_NAME;
  }

  public function serialize(DOMDocument $document)
  {
    $wsdl = ckXsdNamespace::get('wsdl');

    $node = $document->createElementNS($wsdl->getUrl(), $wsdl->qualify($this->getNodeName()));
    $types_node = $document->createElementNS($wsdl->getUrl(), $wsdl->qualify('types'));

    $node->appendChild($types_node);

    foreach($this->getPortTypes() as $portType)
    {
      $node->appendChild($portType->serialize($document));
    }

    foreach($this->getBindings() as $binding)
    {
      $node->appendChild($binding->serialize($document));
    }

    foreach($this->getMessages() as $message)
    {
      $node->appendChild($message->serialize($document));
    }

    foreach($this->getServices() as $service)
    {
      $node->appendChild($service->serialize($document));
    }

    return $node;
  }
}
