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
 * ckDocBlockParser provides methods to parse information from a doc comment block.
 *
 * @package    ckWsdlGenerator
 * @author     Christian Kerl <christian-kerl@web.de>
 */
class ckDocBlockParser
{
  /**
   * Pattern for '@param' tag with the type name, the variable name and an optional description.
   */
  //                               *   @param   (    type_name    )    $(  var_name  )    ( desc )
  const PARAM_PATTERN     = '|^\s*\*\s*@param\s+([0-9A-Za-z_\[\]]+)\s+\$([0-9A-Za-z_]+)\s*(.*)$|';

  /**
   * Pattern for '@return' tag with the type name and an optional description.
   */
  //                               *   @return   (    type_name    )   ( desc )
  const RETURN_PATTERN    = '|^\s*\*\s*@return\s+([0-9A-Za-z_\[\]]+)\s*(.*)$|';

  /**
   * Pattern for '@var' tag with the type name and an optional description.
   */
  //                               *   @var   (    type_name    )   ( desc )
  const PROPERTY_PATTERN  = '|^\s*\*\s*@var\s+([0-9A-Za-z_\[\]]+)\s*(.*)$|';

  /**
   * Pattern for '@ws-header' tag with the header name and the type name.
   */
  //                               *   @ws-header      ( header_name ) :   (    type_name    )
  const WSHEADER_PATTERN  = '|^\s*\*\s*@ws-header\s+(?:([0-9A-Za-z_]+)\:\s+([0-9A-Za-z_\[\]]+))\s*$|';

  /**
   * Pattern for '@ws-method' tag with the method name.
   */
  //                               *   @ws-method      ( method_name )
  const WSMETHOD_PATTERN  = '|^\s*\*\s*@ws-method\s+([0-9A-Za-z_]+)\s*$|';

  /**
   * Pattern for any tag starting with '@', contains a placeholder for the tag name replaceable with {@link sprintf()}.
   */
  //                               *   @<>
  const ANYDOCTAG_PATTERN = '|^\s*\*\s*@%s.*$|';

  /**
   * The mode for {@link count()} to enable recursive counting of arrays.
   */
  const COUNT_RECURSIVE = 1;

  /**
   * The line delimiter for splitting a doc comment block.
   */
  const LINE_DELIMITER = "\n";

  /**
   * Parses all function parameters from a given doc comment block specified with a '@param' tag.
   *
   * @param string $str A doc comment block
   *
   * @return array An array containing an array foreach '@param' tag found, which contains the parameter name, type and description
   */
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

  /**
   * Parses a function return type specified with a '@return' tag from a given doc comment block.
   *
   * @param string $str A doc comment block
   *
   * @return array An array containing the return type and description
   */
  public static function parseReturn($str)
  {
    $tmp = self::parse($str, self::RETURN_PATTERN);

    if(count($tmp, self::COUNT_RECURSIVE) < 3)
    {
      return array();
    }

    return array('type' => $tmp[0][0], 'desc' => $tmp[0][1]);
  }

  /**
   * Parses a class property specified with a '@var' tag from a given doc comment block.
   *
   * @param string $str A doc comment block
   *
   * @return array An array containing the property type and description
   */
  public static function parseProperty($str)
  {
    $tmp = self::parse($str, self::PROPERTY_PATTERN);

    if(count($tmp, self::COUNT_RECURSIVE) < 3)
    {
      return array();
    }

    return array('type' => $tmp[0][0], 'desc' => $tmp[0][1]);
  }

  /**
   * Parses all webservice headers from a given doc comment block specified with a '@ws-header' tag.
   *
   * @param string $str A doc comment block
   *
   * @return array An array containing an array foreach '@ws-header' found, which contains the header name and data type
   */
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

  /**
   * Parses a '@ws-method' tag from a given doc comment block.
   *
   * @param string $str A doc comment block
   *
   * @return array An array containing the method name
   */
  public static function parseMethod($str)
  {
    $tmp = self::parse($str, self::WSMETHOD_PATTERN);

    if(count($tmp, self::COUNT_RECURSIVE) < 2)
    {
      return array();
    }

    return array('name' => $tmp[0][0]);
  }

  /**
   * Checks if a given doc comment block contains a given tag.
   *
   * @param string $str A doc comment block
   * @param string $tag A tag name
   *
   * @return boolean True, if the tag is found, false otherwise
   */
  public static function hasDocTag($str, $tag)
  {
    return count(self::parse($str, sprintf(self::ANYDOCTAG_PATTERN, $tag))) > 0;
  }

  /**
   * Splits a given doc comment block into its lines and trys to match a given pattern against each line.
   *
   * @param string $str     A doc comment block
   * @param string $pattern A pattern to match every line against
   *
   * @return array An array containing all matches
   */
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