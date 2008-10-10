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
 * @author     Christian Kerl <christian-kerl@web.de>
 */
class ckDocBlockParser
{
  //                               *   @param   (    type_name    )    $(  var_name  )    ( desc )
  const PARAM_PATTERN     = '|^\s*\*\s*@param\s+([0-9A-Za-z_\[\]]+)\s+\$([0-9A-Za-z_]+)\s*(.*)$|';

  //                               *   @return   (    type_name    )   ( desc )
  const RETURN_PATTERN    = '|^\s*\*\s*@return\s+([0-9A-Za-z_\[\]]+)\s*(.*)$|';

  //                               *   @var   (    type_name    )   ( desc )
  const PROPERTY_PATTERN  = '|^\s*\*\s*@var\s+([0-9A-Za-z_\[\]]+)\s*(.*)$|';

  //                               *   @ws-header      ( header_name ) :   (    type_name    )
  const WSHEADER_PATTERN  = '|^\s*\*\s*@ws-header\s+(?:([0-9A-Za-z_]+)\:\s+([0-9A-Za-z_\[\]]+))\s*$|';

  //                               *   @ws-method      ( method_name )
  const WSMETHOD_PATTERN  = '|^\s*\*\s*@ws-method\s+([0-9A-Za-z_]+)\s*$|';

  //                               *   @<>
  const ANYDOCTAG_PATTERN = '|^\s*\*\s*@%s.*$|';

  const COUNT_RECURSIVE = 1;
  const LINE_DELIMITER = "\n";

  public static function parseParameters($str)
  {
    $result = array();
    $tmp = self::parse($str, self::PARAM_PATTERN);

    if(count($tmp, self::COUNT_RECURSIVE) < 4)
    {
      return $result;
    }

    foreach($tmp as $param)
    {
      $result[] = array('name' => $param[1], 'type' => $param[0], 'desc' => $param[2]);
    }

    return $result;
  }

  public static function parseReturn($str)
  {
    $tmp = self::parse($str, self::RETURN_PATTERN);

    if(count($tmp, self::COUNT_RECURSIVE) < 3)
    {
      return array();
    }

    return array('type' => $tmp[0][0], 'desc' => $tmp[0][1]);
  }

  public static function parseProperty($str)
  {
    $tmp = self::parse($str, self::PROPERTY_PATTERN);

    if(count($tmp, self::COUNT_RECURSIVE) < 3)
    {
      return array();
    }

    return array('type' => $tmp[0][0], 'desc' => $tmp[0][1]);
  }

  public static function parseHeader($str)
  {
    $result = array();
    $tmp = self::parse($str, self::WSHEADER_PATTERN);

    if(count($tmp, self::COUNT_RECURSIVE) < 3)
    {
      return $result;
    }

    foreach($tmp as $header)
    {
      $result[] = array('name' => $header[0], 'type' => $header[1]);
    }

    return $result;
  }

  public static function parseMethod($str)
  {
    $tmp = self::parse($str, self::WSMETHOD_PATTERN);

    if(count($tmp, self::COUNT_RECURSIVE) < 2)
    {
      return array();
    }

    return array('name' => $tmp[0][0]);
  }

  public static function hasDocTag($str, $tag)
  {
    return count(self::parse($str, sprintf(self::ANYDOCTAG_PATTERN, $tag))) > 0;
  }

  private static function parse($str, $pattern)
  {
    $result = array();
    $lines = explode(self::LINE_DELIMITER, $str);

    foreach($lines as $line)
    {
      $matches = array();

      if(preg_match($pattern, $line, $matches))
      {
        array_shift($matches);
        $result[] = $matches;
      }
    }

    return $result;
  }
}