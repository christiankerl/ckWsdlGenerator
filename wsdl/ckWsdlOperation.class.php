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

/**
 * Enter description here...
 *
 * @package    ckWsdlGenerator
 * @subpackage wsdl
 * @author     Christian Kerl <christian-kerl@web.de>
 */
class ckWsdlOperation implements ISerializable
{
  public static function create($name, ReflectionMethod $method)
  {
    
  }
  
  const ELEMENT_NAME = 'operation';
  
  protected $name;
  protected $input;
  protected $output;
  
  public function getName()
  {
    return $this->name;
  }
  
  public function setName($value)
  {
    $this->name = $value;
  }
  
  /**
   * Enter description here...
   *
   * @return ckWsdlMessage
   */
  public function getInput()
  {
    return $this->input;
  }
  
  /**
   * Enter description here...
   *
   * @return ckWsdlMessage
   */
  public function getOutput()
  {
    return $this->output;
  }
  
  protected function __construct()
  {
    
  }
  
  public function serialize(DOMDocument $document)
  {
     $wsdl = ckXsdNamespace::get('wsdl');
     $tns  = ckXsdNamespace::get('tns');
     
     $node = $document->createElementNS($wsdl->getUrl(), $wsdl->qualify(self::ELEMENT_NAME));
     
     $node->setAttribute('name', $this->getName());
     $node->setAttribute('parameterOrder', implode(' ', $this->getInput()->getParts()));
     
     $input_node = $document->createElementNS($wsdl->getUrl(), $wsdl->qualify('input'));
     $input_node->setAttribute('message', $tns->qualify($this->getInput()->getName()));
     
     $output_node = $document->createElementNS($wsdl->getUrl(), $wsdl->qualify('output'));
     $output_node->setAttribute('message', $tns->qualify($this->getOutput()->getName()));
     
     $node->appendChild($input_node);
     $node->appendChild($output_node);
     
     return $node;
  }
}