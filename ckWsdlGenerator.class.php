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

require_once(dirname(__FILE__).'/vendor/addendum/annotations.php');

/**
 * ckWsdlGenerator provides methods to generate a webservice definition in wsdl format from php methods.
 *
 * @package    ckWsdlGenerator
 * @author     Christian Kerl <christian-kerl@web.de>
 */
class ckWsdlGenerator
{
  /**
   * The wsdl generator context representing the webservice to generate.
   *
   * @var ckWsdlGeneratorContext
   */
  protected $context = null;

  /**
   * Constructor initializing the wsdl generator with a given wsdl generator context.
   *
   * @param $context A wsdl generator context
   */
  public function __construct(ckWsdlGeneratorContext $context)
  {
    $this->context = $context;
  }

  /**
   * Adds a given annotated php method to the webservice definition.
   *
   * @param ReflectionAnnotatedMethod $method A ReflectionAnnotatedMethod object representing the method, which should be added to the webservice
   *
   * @return boolean True if the method was succesfully added, false otherwise
   */
  public function addMethod(ReflectionAnnotatedMethod $method)
  {
    if($this->context->matchesContext($method))
    {
      $this->methods[] = $method;

      return true;
    }
    else
    {
      return false;
    }
  }

  /**
   * Generates a webservice definition in the wsdl format and optionally saves it to a given file.
   *
   * @param string $file The name of the file to which to save the generated webservice definition
   *
   * @return string A string containing the generated webservice definition
   */
  public function save($file = null)
  {
    $portType = new ckWsdlPortType();
    $portType->setName($this->context->getName().'PortType');

    foreach($this->methods as $method)
    {
      $portType->addOperation(ckWsdlOperation::create($name, $method));
    }

    $binding = new ckWsdlSoapBindingDecorator();
    $binding->setName($this->context->getName().'Binding');
    $binding->setPortType($portType);

    $port = new ckWsdlSoapPortDecorator();
    $port->setName($this->context->getName().'Port');
    $port->setLocation($this->context->getLocation());
    $port->setBinding($binding);

    $service = new ckWsdlService();
    $service->setName($this->context->getName().'Service');
    $service->addPort($port);

    $def = new ckWsdlDefinitions();
    $def->setName($this->context->getName());
    $def->addPortType($portType);
    $def->addBinding($binding);
    $def->addService($service);

    $doc = new DOMDocument('1.0', 'utf-8');
    $doc->formatOutput = true;
    $doc->appendChild($def->serialize($doc));

    $content = $doc->saveXML();

    if(!is_null($file))
    {
      file_put_contents($file, $content);
    }

    return $content;
  }
}