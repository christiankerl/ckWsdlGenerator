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

  protected $name;
  protected $portTypes = array();
  protected $bindings = array();
  protected $services = array();

  public function getName()
  {
    return $this->name;
  }

  public function setName($value)
  {
    $this->name = $value;
  }

  public function getTypes()
  {
    return ckXsdType::getComplexAndArrayTypes();
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

  public function getMessages()
  {
    $result = array();

    foreach($this->getPortTypes() as $portType)
    {
      foreach($portType->getOperations() as $operation)
      {
        $result[] = $operation->getInput();
        $result[] = $operation->getOutput();
      }
    }

    return $result;
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
    $wsdl    = ckXsdNamespace::get('wsdl');
    $xsd     = ckXsdNamespace::get('xsd');
    $tns     = ckXsdNamespace::get('tns');
    $soapenc = ckXsdNamespace::get('soapenc');

    $node = $document->createElementNS($wsdl->getUrl(), $wsdl->qualify($this->getNodeName()));
    $node->setAttribute('xmlns', $wsdl->getUrl());
    $node->setAttribute('name', $this->getName());
    $node->setAttribute('targetNamespace', $tns->getUrl());

    // kind of hack to register all namespaces
    $node->setAttribute($tns->getXmlns(), $tns->getUrl());
    $node->setAttribute($soapenc->getXmlns(), $soapenc->getUrl());

    $schema_node = $document->createElementNS($xsd->getUrl(), $xsd->qualify('schema'));
    $schema_node->setAttribute('xmlns', $xsd->getUrl());
    $schema_node->setAttribute('targetNamespace', $tns->getUrl());

    foreach($this->getTypes() as $type)
    {
      $schema_node->appendChild($type->serialize($document));
    }

    $types_node = $document->createElementNS($wsdl->getUrl(), $wsdl->qualify('types'));
    $types_node->appendChild($schema_node);

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
