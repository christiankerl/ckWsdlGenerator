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

ckXsdNamespace::set('xsd', 'http://www.w3.org/2001/XMLSchema');
ckXsdNamespace::set('soap', 'http://schemas.xmlsoap.org/wsdl/soap/');
ckXsdNamespace::set('soaphttp', 'http://schemas.xmlsoap.org/soap/http');
ckXsdNamespace::set('soapenc', 'http://schemas.xmlsoap.org/soap/encoding/');
ckXsdNamespace::set('wsdl', 'http://schemas.xmlsoap.org/wsdl/');

/**
 * ckXsdNamespace represents a xml namespace and provides a central xml namespace registry.
 *
 * @package    ckWsdlGenerator
 * @subpackage xsd
 * @author     Christian Kerl <christian-kerl@web.de>
 */
class ckXsdNamespace
{
  /**
   * An array containing all registered namespaces.
   *
   * @var array
   */
  protected static $namespaceRegistry = array();

  /**
   * Gets a namespace from the registry identified by its short name.
   *
   * @param string $shortName The short name of the namespace
   *
   * @return ckXsdNamespace The namespace, if one with the given short name exists, null otherwise
   */
  public static function get($shortName)
  {
    if(isset(self::$namespaceRegistry[$shortName]))
    {
      return self::$namespaceRegistry[$shortName];
    }
    else
    {
      return null;
    }
  }

  /**
   * Gets all registered namespaces.
   *
   * @return array An array containing all registered namespaces
   */
  public static function getAll()
  {
    return self::$namespaceRegistry;
  }

  /**
   * Creates a new namespace and adds it to the registry.
   *
   * @param string $shortName The short name of the namespace
   * @param string $url       The namespace url
   *
   * @return ckXsdNamespace The created namespace
   */
  public static function set($shortName, $url)
  {
    $ns = self::get($shortName);

    if(is_null($ns))
    {
        $ns = new ckXsdNamespace($shortName, $url);

        self::$namespaceRegistry[$shortName] = $ns;
    }

    return $ns;
  }

  /**
   * The short name of the namespace.
   *
   * @var string
   */
  protected $shortName;

  /**
   * The namespace url.
   *
   * @var string
   */
  protected $url;

  /**
   * Gets the short name of the namespace.
   *
   * @return string The short name
   */
  public function getShortName()
  {
    return $this->shortName;
  }

  /**
   * Sets the short name of the namespace.
   *
   * @param string $value The short name of the namespace
   */
  protected function setShortName($value)
  {
    $this->shortName = $value;
  }

  /**
   * Gets the namespace url.
   *
   * @return string The namespace url
   */
  public function getUrl()
  {
    return $this->url;
  }

  /**
   * Sets the namespace url.
   *
   * @param string $value The namespace url
   */
  protected function setUrl($value)
  {
    $this->url = $value;
  }

  /**
   * Gets the xmlns attribute name for the namespace.
   *
   * @return string The xmlns attribute name
   */
  public function getXmlns()
  {
    return sprintf('xmlns:%s', $this->getShortName());
  }

  /**
   * Constructor initializing the new namespace with the given short name and the given url.
   *
   * @param string $shortName The short name of the namespace
   * @param string $url       The namespace url
   */
  public function __construct($shortName, $url)
  {
    $this->setShortName($shortName);
    $this->setUrl($url);
  }

  /**
   * Qualifies a given name against the namespace.
   *
   * @param string $name The name to qualify
   *
   * @return string The qualified name
   */
  public function qualify($name)
  {
    return sprintf('%s:%s', $this->getShortName(), $name);
  }
}