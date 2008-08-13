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
    $soap = ckXsdNamespace::get('soap');
    $tns  = ckXsdNamespace::get('tns');

    $node = $document->createElementNS($wsdl->getUrl(), $wsdl->qualify($this->getNodeName()));

    $node->setAttribute('name', $this->getName());
    $node->setAttribute('type', $tns->qualify($this->getPortType()->getName()));

    $binding_node = $document->createElementNS($soap->getUrl(), $soap->qualify($this->getNodeName()));
    $binding_node->setAttribute('style', 'rpc');
    $binding_node->setAttribute('transport', ckXsdNamespace::get('soaphttp')->getUrl());

    $node->appendChild($binding_node);

    foreach($this->getPortType()->getOperations() as $operation)
    {
      $op_node = $document->createElementNS($wsdl->getUrl(), $wsdl->qualify($operation->getNodeName()));
      $op_node->setAttribute('name', $operation->getName());

      $op_soap_node = $document->createElementNS($soap->getUrl(), $soap->qualify($operation->getNodeName()));
      $op_soap_node->setAttribute('soapAction', $tns->getUrl().$operation->getName());
      $op_soap_node->setAttribute('style', 'rpc');
      $op_node->appendChild($op_soap_node);

      if(!is_null($operation->getInput()))
      {
        $in_node = $document->createElementNS($wsdl->getUrl(), $wsdl->qualify('input'));
        $in_node->appendChild($this->getSoapBodyNode($document, $operation->getInput()));

        $op_node->appendChild($in_node);
      }

      if(!is_null($operation->getOutput()))
      {
        $out_node = $document->createElementNS($wsdl->getUrl(), $wsdl->qualify('output'));
        $out_node->appendChild($this->getSoapBodyNode($document, $operation->getOutput()));

        $op_node->appendChild($out_node);
      }

      $node->appendChild($op_node);
    }

    return $node;
  }

  private function getSoapBodyNode($document, $message)
  {
    $soap    = ckXsdNamespace::get('soap');
    $soapenc = ckXsdNamespace::get('soapenc');
    $tns     = ckXsdNamespace::get('tns');

    $body_node = $document->createElementNS($soap->getUrl(), $soap->qualify('body'));

    $parts = array();

    foreach($message->getParts() as $part)
    {
      $parts[] = $part->getName();
    }

    $body_node->setAttribute('parts', implode(' ', $parts));
    $body_node->setAttribute('use', 'encoded');
    $body_node->setAttribute('namespace', $tns->getUrl());
    $body_node->setAttribute('encodingStyle', $soapenc->getUrl());

    return $body_node;
  }
}