<?php
/**
 * This file is part of the ckWebServicePlugin
 *
 * @package   ckWsdlGenerator
 * @author    Christian Kerl <christian-kerl@web.de>
 * @copyright Copyright (c) 2008, Christian Kerl
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @version   SVN: $Id: ckSoapHandler.class.php 8064 2008-03-24 16:51:45Z chrisk $
 */

ckXsdSimpleType::create('int');
ckXsdSimpleType::create('string');
ckXsdSimpleType::create('float');

/**
 * Enter description here...
 *
 * @package    ckWsdlGenerator
 * @subpackage xsd
 * @author     Christian Kerl <christian-kerl@web.de>
 */
class ckXsdSimpleType extends ckXsdType
{
  public static function create($typeName)
  {
    $type = new ckXsdSimpleType();
    $type->setName($typeName);
    $type->setNamespace(ckXsdNamespace::get('xsd'));
    
    self::set($typeName, $type);
    
    return $type;
  }
  
  protected function __construct()
  {
    parent::__construct();
  }
  
  public function serialize(DOMDocument $document)
  {
    return null;
  }
}