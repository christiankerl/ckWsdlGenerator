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
 * ckString provides methods for string manipulation.
 *
 * @package    ckWsdlGenerator
 * @subpackage util
 * @author     Christian Kerl <christian-kerl@web.de>
 */
class ckString
{
  /**
   * Makes a string's first character lowercase.
   *
   * @param  string $str A string
   *
   * @return string      The string with first character lowercased
   */
  public static function lcfirst($str)
  {
    if(is_string($str) && strlen($str) > 0)
    {
      $str[0] = strtolower($str[0]);
    }

    return $str;
  }

  /**
   * Makes a string's first character uppercase.
   *
   * @param  string $str A string
   *
   * @return string      The string with first character uppercased
   */
  public static function ucfirst($str)
  {
    return ucfirst($str);
  }

  /**
   * Checks if a string starts with a given string.
   *
   * @param  string $str    A string
   * @param  string $substr A string to check against
   *
   * @return bool           True if str starts with substr
   */
  public static function startsWith($str, $substr)
  {
    if(is_string($str) && is_string($substr) && strlen($str) >= strlen($substr))
    {
      return $substr == substr($str, 0, strlen($substr));
    }
  }

  /**
   * Checks if a string ends with a given string.
   *
   * @param  string $str    A string
   * @param  string $substr A string to check against
   *
   * @return bool           True if str ends with substr
   */
  public static function endsWith($str, $substr)
  {
    if(is_string($str) && is_string($substr) && strlen($str) >= strlen($substr))
    {
      return $substr == substr($str, strlen($str) - strlen($substr));
    }
  }

  /**
   * Fixes a bug in PHP < 5.2 where implode() doesn't call object's __toString() method.
   *
   * @see implode()
   */
  public static function implode($delimiter, $array)
  {
    if(version_compare(PHP_VERSION, '5.2.0', '>='))
    {
      return implode($delimiter, $array);
    }
    else
    {
      return implode($delimiter, array_map(array(__CLASS__, 'strval'), $array));
    }
  }

  /**
   * Fixes strval() not calling object's __toString() method.
   *
   * @see strval()
   */
  private static function strval($object)
  {
    if(is_object($object) && method_exists($object, '__toString'))
    {
      return $object->__toString();
    }
    else
    {
      return strval($object);
    }
  }
}