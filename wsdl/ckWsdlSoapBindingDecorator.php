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
 * @subpackage wsdl
 * @author     Christian Kerl <christian-kerl@web.de>
 */
class ckWsdlSoapBindingDecorator extends ckWsdlBindingDecorator
{
  public function serialize(DOMDocument $document)
  {
     $wsdl = ckXsdNamespace::get('wsdl');
     $tns  = ckXsdNamespace::get('tns');
     
     $node = $document->createElementNS($wsdl->getUrl(), $wsdl->qualify(self::ELEMENT_NAME));
     
     $node->setAttribute('name', $this->getName());     
     $node->setAttribute('type', $tns->qualify($this->getPortType()->getName()));
          
     return $node;
  }
}