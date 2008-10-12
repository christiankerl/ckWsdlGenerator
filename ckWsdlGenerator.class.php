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
 * ckWsdlGenerator provides methods to generate a webservice definition in wsdl format from php methods.
 *
 * @package    ckWsdlGenerator
 * @author     Christian Kerl <christian-kerl@web.de>
 */
class ckWsdlGenerator
{
  /**
   * The tag that has to be present in a method's doc comment block, when {@link checkEnablement} is set to true.
   */
  const ENABLEMENT_DOCTAG = 'ws-enable';

  /**
   * The name of the webservice.
   *
   * @var string
   */
  protected $name;

  /**
   * The targetnamespace of the wsdl document.
   *
   * @var ckXsdNamespace
   */
  protected $namespace;

  /**
   * The webservice endpoint.
   *
   * @var string
   */
  protected $endpoint;

  /**
   * Wether a method's doc comment block is checked for the presence of the {@link ENABLEMENT_DOCTAG}.
   *
   * @var boolean
   */
  protected $checkEnablement = false;

  /**
   * An array of ReflectionMethod objects representng methods, which should be added to the webservice.
   *
   * @var array
   */
  protected $methods = array();

  /**
   * Gets the webservice name.
   *
   * @return string The webservice name
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * Gets the targetnamespace of the wsdl document.
   *
   * @return ckXsdNamespace The targetnamespace of the wsdl document
   */
  public function getNamespace()
  {
    return $this->namespace;
  }

  /**
   * Gets the webservice endpoint.
   *
   * @return string The webservice endpoint
   */
  public function getEndpoint()
  {
    return $this->endpoint;
  }

  /**
   * Get wether a method's doc comment block is checked for the presence of the {@link ENABLEMENT_DOCTAG}, before it is added to the webservice definition.
   *
   * @return boolean True, if the check is enabled, false otherwise
   */
  public function getCheckEnablement()
  {
    return $this->checkEnablement;
  }

  /**
   * Set wether a method's doc comment block is checked for the presence of the {@link ENABLEMENT_DOCTAG}, before it is added to the webservice definition.
   *
   * @param boolean $value A boolean determining if the check should be enabled.
   */
  public function setCheckEnablement($value)
  {
    $this->checkEnablement = $value;
  }

  /**
   * Constructor initializing the wsdl generator.
   *
   * @param string $name      The webservice name
   * @param string $namespace The targetnamespace of the wsdl document
   * @param string $endpoint  The webservice endpoint
   */
  public function __construct($name, $namespace, $endpoint)
  {
    $this->name = $name;
    $this->namespace = ckXsdNamespace::set('tns', $this->normalizeNamespaceUri($namespace));
    $this->endpoint = $endpoint;
  }

  /**
   * Adds a method under a given name to the webservice definition and performs the enablement check if {@link checkEnablement} is set to true.
   *
   * @param string           $name   The name of the method in the webservice definition
   * @param ReflectionMethod $method A ReflectionMethod object representing the method, which should be added to the webservice
   *
   * @return boolean True if the method was succesfully added, false otherwise
   */
  public function addMethod($name, ReflectionMethod $method)
  {
    if(!$this->getCheckEnablement() || ckDocBlockParser::hasDocTag($method->getDocComment(), self::ENABLEMENT_DOCTAG))
    {
      $this->methods[$name] = $method;

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
    $portType->setName($this->getName().'PortType');

    foreach($this->methods as $name => $method)
    {
      $portType->addOperation(ckWsdlOperation::create($name, $method));
    }

    $binding = new ckWsdlSoapBindingDecorator();
    $binding->setName($this->getName().'Binding');
    $binding->setPortType($portType);

    $port = new ckWsdlSoapPortDecorator();
    $port->setName($this->getName().'Port');
    $port->setLocation($this->getEndpoint());
    $port->setBinding($binding);

    $service = new ckWsdlService();
    $service->setName($this->getName().'Service');
    $service->addPort($port);

    $def = new ckWsdlDefinitions();
    $def->setName($this->getName());
    $def->addPortType($portType);
    $def->addBinding($binding);
    $def->addService($service);

    $doc = new DOMDocument();
    $doc->formatOutput = true;
    $doc->appendChild($def->serialize($doc));

    $content = $doc->saveXML();

    if(!is_null($file))
    {
      file_put_contents($file, $content);
    }

    return $content;
  }

  /**
   * Normalizes a namespace uri, this means adding a slash at the end of the uri, if none is present.
   *
   * @param string $namespace The namespace uri to normalize
   *
   * @return string The normalized namespace uri
   */
  private function normalizeNamespaceUri($namespace)
  {
    return !ckString::endsWith($namespace, '/') ? $namespace.'/' : $namespace;
  }
}