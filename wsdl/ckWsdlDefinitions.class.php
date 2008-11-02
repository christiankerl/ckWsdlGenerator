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
 * ckWsdlDefinitions represents a wsdl definition.
 *
 * @package    ckWsdlGenerator
 * @subpackage wsdl
 * @author     Christian Kerl <christian-kerl@web.de>
 */
class ckWsdlDefinitions implements ckDOMSerializable
{
  /**
   * The name of the root node of the xml representation.
   */
  const ELEMENT_NAME = 'definitions';

  /**
   * The name of the webservice definition.
   *
   * @var string
   */
  protected $name;

  /**
   * An array containing all port types of the definition.
   *
   * @var array
   */
  protected $portTypes = array();

  /**
   * An array containing all bindings of the definition.
   *
   * @var array
   */
  protected $bindings = array();

  /**
   * An array containing all services of the definition.
   *
   * @var array
   */
  protected $services = array();

  /**
   * Gets the name of the webservice definition.
   *
   * @return string The name of the webservice definition
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * Sets the name of the webservice definition.
   *
   * @param string $value The name of the webservice definition
   */
  public function setName($value)
  {
    $this->name = $value;
  }

  /**
   * Gets all complex and array types.
   *
   * @return array An array containing all complex and array types
   */
  public function getTypes()
  {
    return ckXsdType::getComplexAndArrayTypes();
  }

  /**
   * Adds a port type to the definition.
   *
   * @param ckWsdlPortType $value A port type
   */
  public function addPortType(ckWsdlPortType $value)
  {
    $this->portTypes[] = $value;
  }

  /**
   * Gets all port types of the definition.
   *
   * @return array An array containing all port types
   */
  public function getPortTypes()
  {
    return $this->portTypes;
  }

  /**
   * Adds a binding to the definition.
   *
   * @param ckWsdlBindingDecorator $value A binding
   */
  public function addBinding(ckWsdlBindingDecorator $value)
  {
    $this->bindings[] = $value;
  }

  /**
   * Gets all bindings of the definition.
   *
   * @return array An array containing all bindings
   */
  public function getBindings()
  {
    return $this->bindings;
  }

  /**
   * Gets all messages of the operations of the different port types.
   *
   * @return array An array containing all messages
   */
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

  /**
   * Adds a service to the definition.
   *
   * @param ckWsdlService $value A service
   */
  public function addService(ckWsdlService $value)
  {
    $this->services[] = $value;
  }

  /**
   * Gets all services of the definition.
   *
   * @return array An array containing all services
   */
  public function getServices()
  {
    return $this->services;
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
