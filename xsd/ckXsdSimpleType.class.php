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
 * @subpackage xsd
 * @author     Christian Kerl <christian-kerl@web.de>
 */
class ckXsdSimpleType extends ckXsdType
{
  protected static $SIMPLE_TYPES = array('boolean', 'integer', 'float', 'string');

  /**
   * Enter description here...
   *
   * @param string $name
   *
   * @return boolean
   */
  public static function isSimpleType($name)
  {
    return in_array($name, self::$SIMPLE_TYPES);
  }

  public static function create($name)
  {
    return new ckXsdSimpleType($name, ckXsdNamespace::get('xsd'));
  }

  protected function __construct($name = null, ckXsdNamespace $namespace = null)
  {
    parent::__construct($name, $namespace);
  }

  public function serialize(DOMDocument $document)
  {
    throw new Exception('Not supported.');
  }
}