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

      $header_nodes = array();

      if(!is_null($operation->getInput()))
      {
        $in_node = $document->createElementNS($wsdl->getUrl(), $wsdl->qualify('input'));
        $in_node->appendChild($this->getSoapBodyNode($document, $operation->getInput()));

        foreach($operation->getInput()->getHeaderParts() as $header)
        {
          $header_node = $this->getSoapHeaderNode($document, $operation->getInput(), $header);
          $header_nodes[] = clone $header_node;
          $in_node->appendChild($header_node);
        }

        $op_node->appendChild($in_node);
      }

      if(!is_null($operation->getOutput()))
      {
        $out_node = $document->createElementNS($wsdl->getUrl(), $wsdl->qualify('output'));
        $out_node->appendChild($this->getSoapBodyNode($document, $operation->getOutput()));

        foreach($header_nodes as $header_node)
        {
          $out_node->appendChild($header_node);
        }

        $op_node->appendChild($out_node);
      }

      $node->appendChild($op_node);
    }

    return $node;
  }

  private function getSoapBodyNode(DOMDocument $document, ckWsdlMessage $message)
  {
    $soap    = ckXsdNamespace::get('soap');
    $soapenc = ckXsdNamespace::get('soapenc');
    $tns     = ckXsdNamespace::get('tns');

    $body_node = $document->createElementNS($soap->getUrl(), $soap->qualify('body'));
    $body_node->setAttribute('parts', implode(' ', $message->getBodyParts()));
    $body_node->setAttribute('use', 'encoded');
    $body_node->setAttribute('namespace', $tns->getUrl());
    $body_node->setAttribute('encodingStyle', $soapenc->getUrl());

    return $body_node;
  }

  private function getSoapHeaderNode(DOMDocument $document, ckWsdlMessage $message, ckWsdlPart $part)
  {
    $soap    = ckXsdNamespace::get('soap');
    $soapenc = ckXsdNamespace::get('soapenc');
    $tns     = ckXsdNamespace::get('tns');

    $header_node = $document->createElementNS($soap->getUrl(), $soap->qualify('header'));
    $header_node->setAttribute('message', $tns->qualify($message->getName()));
    $header_node->setAttribute('part', $part->getName());
    $header_node->setAttribute('use', 'encoded');
    $header_node->setAttribute('namespace', $tns->getUrl());
    $header_node->setAttribute('encodingStyle', $soapenc->getUrl());

    return $header_node;
  }
}