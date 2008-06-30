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

ckXsdNamespace::set('xsd', 'http://www.w3.org/2001/XMLSchema');
ckXsdNamespace::set('soap', 'http://schemas.xmlsoap.org/wsdl/soap/');
ckXsdNamespace::set('soapenc', 'http://schemas.xmlsoap.org/soap/encoding/');
ckXsdNamespace::set('wsdl', 'http://schemas.xmlsoap.org/wsdl/');

/**
 * Enter description here...
 *
 * @package    ckWsdlGenerator
 * @subpackage xsd
 * @author     Christian Kerl <christian-kerl@web.de>
 */
class ckXsdNamespace
{
  protected static $namespaceRegistry = array();
  
  /**
   * Enter description here...
   *
   * @param string $key
   * @return ckXsdNamespace
   */
  public static function get($key)
  {    
    if(isset(self::$namespaceRegistry[$key]))
    {
      return self::$namespaceRegistry[$key];
    }
    else
    {
      return null;
    }
  }
  
  /**
   * Enter description here...
   *
   * @param string $key
   * @param string $url
   * @param string $shortName
   */
  public static function set($key, $url, $shortName = null)
  {
    $shortName = is_null($shortName) ? $key : $shortName;
    
    self::$namespaceRegistry[$key] = new ckXsdNamespace($shortName, $url);
  }
  
  protected $shortname;
  protected $url;
  
  public function getShortName()
  {
    return $this->shortname;
  }
  
  public function setShortName($value)
  {
    $this->shortname = $value;
  }
  
  public function getUrl()
  {
    return $this->url;
  }
  
  public function setUrl($value)
  {
    $this->url = $value;
  }
  
  public function __construct($shortname, $url)
  {
    $this->setShortName($shortname);
    $this->setUrl($url);
  }
  
  public function qualify($item)
  {
    return sprintf('%s:%s', $this->getShortName(), $item);
  }
}