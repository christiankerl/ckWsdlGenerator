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
 * ckWsdlGeneratorContext represents a webservice, which can be generated with a ckWsdlGenerator.
 *
 * @package    ckWsdlGenerator
 * @author     Christian Kerl <christian-kerl@web.de>
 */
class ckWsdlGeneratorContext
{
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
   * The endpoint location of the webservice.
   *
   * @var string
   */
  protected $location;

  /**
   * Determines if the webservice is the default webservice.
   *
   * @var bool
   */
  protected $default = true;

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
   * Gets the endpoint location of the webservice.
   *
   * @return string
   */
  public function getLocation()
  {
    if(ckString::isNullOrEmpty($this->location))
    {
      $this->location = $this->getNamespace()->getUrl().$this->getName().'.php';
    }

    return $this->location;
  }

  /**
   * Constructor initializing the wsdl generator context.
   *
   * @param string $name      The webservice name
   * @param string $namespace The targetnamespace of the wsdl document
   * @param string $location  The endpoint location of the webservice
   * @param bool   $default   Indicates if the webservice is the default one
   */
  public function __construct($name, $namespace, $location = null, $default = true)
  {
    $this->name      = $name;
    $this->namespace = ckXsdNamespace::set('tns', $this->normalizeNamespaceUri($namespace));
    $this->location  = $location;
    $this->default   = $default;
  }

  /**
   * Checks if a given method has a WSMethod annotation and if it can be added to the webservice represented by this context.
   *
   * @param ReflectionAnnotatedMethod $method An annotated method to check
   *
   * @return bool True, if the check succeeds, false otherwise
   */
  public function matchesContext(ReflectionAnnotatedMethod $method)
  {
    $hasAnnotation      = ($annotation = $method->getAnnotation('WSMethod')) !== false;
    $isDefaultMethod    = empty($annotation->webservice) && $this->default;
    $isWebserviceMethod = array_search($this->name, array()) !== false;

    return $hasAnnotation && ($isDefaultMethod || $isWebserviceMethod);
  }

  /**
   * Normalizes a given namespace uri, this means adding a slash at end if none is present.
   *
   * @param string $namespace A namespace uri
   *
   * @return string The normalized namespace uri
   */
  private function normalizeNamespaceUri($namespace)
  {
    return !ckString::endsWith($namespace, '/') ? $namespace.'/' : $namespace;
  }
}