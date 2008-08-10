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
  //                              *   @param   (    type_name    )    $(  var_name  )    ( desc )
  const PARAM_PATTERN    = '|^\s*\*\s*@param\s+([0-9A-Za-z_\[\]]+)\s+\$([0-9A-Za-z_]+)\s*(.*)$|';

  //                              *   @return   (    type_name    )   ( desc )
  const RETURN_PATTERN   = '|^\s*\*\s*@return\s+([0-9A-Za-z_\[\]]+)\s*(.*)$|';

  //                              *   @var   (    type_name    )
  const PROPERTY_PATTERN = '|^\s*\*\s*@var\s+([0-9A-Za-z_\[\]]+)\s*$|';

  public static function parseParameters($str)
  {
    $result = array();
    $tmp = self::parse($str, self::PARAM_PATTERN);

    if(count($tmp, 1) < 4)
    {
      return null;
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


    if(count($tmp, 1) < 3)
    {
      return null;
    }

    return array('type' => $tmp[0][0], 'desc' => $tmp[0][1]);
  }

  public static function parseProperty($str)
  {
    $tmp = self::parse($str, self::PROPERTY_PATTERN);

    if(count($tmp, 1) < 2)
    {
      return null;
    }

    return array('type' => $tmp[0][0]);
  }

  private static function parse($str, $pattern)
  {
    $result = array();
    $lines = explode("\n", $str);

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