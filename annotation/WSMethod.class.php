<?php
/**
 * This file is part of the ckWsdlGenerator
 *
 * @package   ckWebServicePlugin
 * @author    Christian Kerl <christian-kerl@web.de>
 * @copyright Copyright (c) 2008, Christian Kerl
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @version   SVN: $Id$
 */

/**
 * The WSMethod annotation identifies methods, which should be added to a webservice.
 *
 * @package    ckWsdlGenerator
 * @subpackage annotation
 * @author     Christian Kerl <christian-kerl@web.de>
 *
 * @Target("method")
 */
class WSMethod extends Annotation
{
  /**
   * The callback, which should be used to create webservice method names for given php methods.
   *
   * @var callback
   */
  protected static $createMethodNameCallback = null;

  /**
   * Sets a callback, which should be used to create webservice method names for given php methods.
   *
   * @param callback $callback
   */
  public static function setCreateMethodNameCallback($callback)
  {
    if(!is_callable($callback))
    {
      throw new InvalidArgumentException();
    }

    self::$createMethodNameCallback = $callback;
  }

  /**
   * The name of the method.
   *
   * @var string
   */
  protected $name;

  /**
   * The names of the webservices the annotated method is part of.
   *
   * @var array
   */
  protected $webservice = array();

  /**
   * The target method of this annotation.
   *
   * @var ReflectionAnnotatedMethod
   */
  protected $target;

  /**
   * (non-PHPdoc)
   * @see vendor/addendum/Annotation#checkConstraints()
   */
  protected function checkConstraints($target)
  {
    $this->name = !ckString::isNullOrEmpty($this->name) ? $this->name : $this->value;
    $this->target = $target;

    if(!is_array($this->webservice) && !is_null($this->webservice))
    {
      $this->webservice = array($this->webservice);
    }
  }

  /**
   * Gets the name of the method.
   *
   * @return string The method name
   */
  public function getName()
  {
    if(ckString::isNullOrEmpty($this->name))
    {
      $this->name = $this->invokeCreateMethodNameCallback($this->target);
    }

    return $this->name;
  }

  /**
   * Gets the names of the webservices the annotated method is part of.
   *
   * @return array The webservice names
   */
  public function getWebservice()
  {
    return $this->webservice;
  }

  /**
   * Invokes the WSMethod::$createMethodNameCallback to create a webservice method name for a given php method.
   *
   * @param ReflectionMethod $target A php method
   *
   * @return string The created webservice method name
   */
  protected function invokeCreateMethodNameCallback(ReflectionMethod $target)
  {
    $callback = is_null(self::$createMethodNameCallback) ? array($this, 'getReflectionMethodName') : self::$createMethodNameCallback;

    return call_user_func($callback, $target);
  }

  /**
   * Invokes the ReflectionMethod::getName() on the given method.
   *
   * @param ReflectionMethod $target
   *
   * @return string The name of the given method
   */
  protected function getReflectionMethodName(ReflectionMethod $target)
  {
    return $target->getName();
  }
}