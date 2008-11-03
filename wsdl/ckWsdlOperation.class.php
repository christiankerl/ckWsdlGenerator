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
 * ckWsdlOperation represents a wsdl operation.
 *
 * @package    ckWsdlGenerator
 * @subpackage wsdl
 * @author     Christian Kerl <christian-kerl@web.de>
 */
class ckWsdlOperation implements ckDOMSerializable
{
  /**
   * Creates a new operation with a given name from a given php method.
   *
   * @param string           $name   The name of the operation
   * @param ReflectionMethod $method A php method
   *
   * @return ckWsdlOperation An operation, which's input corresponds to the parameters and which's output
   *                         corresponds to the return value of the given php method.
   */
  public static function create($name, ReflectionMethod $method)
  {
    $result = new ckWsdlOperation();
    $result->setName($name);

    $params  = ckDocBlockParser::parseParameters($method->getDocComment());
    $headers = ckDocBlockParser::parseHeader($method->getDocComment());
    $return  = ckDocBlockParser::parseReturn($method->getDocComment());

    $result->input = new ckWsdlMessage($name.'Request');

    foreach($params as $param)
    {
      $type = ckXsdType::get($param['type']);

      $result->input->addPart(new ckWsdlPart($param['name'], $type));
    }

    foreach($headers as $header)
    {
      $type = ckXsdType::get($header['type']);
      $type->setName($header['name']);
      ckXsdType::set($header['name'], $type);
      ckXsdType::set($header['type'], null);

      $result->input->addPart(new ckWsdlPart($header['name'], $type, true));
    }

    $result->output = new ckWsdlMessage($name.'Response');

    if(!empty($return))
    {
      $type = ckXsdType::get($return['type']);

      $result->output->addPart(new ckWsdlPart('return', $type));
    }

    return $result;
  }

  /**
   * The name of the root node of the xml representation.
   */
  const ELEMENT_NAME = 'operation';

  /**
   * The name of the operation.
   *
   * @var string
   */
  protected $name;

  /**
   * The input of the operation.
   *
   * @var ckWsdlMessage
   */
  protected $input;

  /**
   * The output of the operation.
   *
   * @var ckWsdlMessage
   */
  protected $output;

  /**
   * Gets the name of the operation.
   *
   * @return string The name of the operation
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * Sets the name of the operation.
   *
   * @param string $value The name of the operation
   */
  public function setName($value)
  {
    $this->name = $value;
  }

  /**
   * Gets the input.
   *
   * @return ckWsdlMessage The input
   */
  public function getInput()
  {
    return $this->input;
  }

  /**
   * Sets the input.
   *
   * @param ckWsdlMessage $value The input
   */
  public function setInput(ckWsdlMessage $value)
  {
    $this->input = $value;
  }

  /**
   * Gets the output.
   *
   * @return ckWsdlMessage The output
   */
  public function getOutput()
  {
    return $this->output;
  }

  /**
   * Sets the output.
   *
   * @param ckWsdlMessage $value The input
   */
  public function setOutput(ckWsdlMessage $value)
  {
    $this->output = $value;
  }

  /**
   * @see ckDOMSerializable::getNodeName()
   */
  public function getNodeName()
  {
    return self::ELEMENT_NAME;
  }

  /**
   * Protected default constructor.
   */
  protected function __construct()
  {
  }

  /**
   * @see ckDOMSerializable::serialize()
   */
  public function serialize(DOMDocument $document)
  {
    $wsdl = ckXsdNamespace::get('wsdl');
    $tns  = ckXsdNamespace::get('tns');

    $node = $document->createElementNS($wsdl->getUrl(), $wsdl->qualify($this->getNodeName()));

    $node->setAttribute('name', $this->getName());

    if(!is_null($this->getInput()))
    {
      $input_node = $document->createElementNS($wsdl->getUrl(), $wsdl->qualify('input'));
      $input_node->setAttribute('message', $tns->qualify($this->getInput()->getName()));

      $node->setAttribute('parameterOrder', implode(' ', $this->getInput()->getBodyParts()));
      $node->appendChild($input_node);
    }

    if(!is_null($this->getOutput()))
    {
      $output_node = $document->createElementNS($wsdl->getUrl(), $wsdl->qualify('output'));
      $output_node->setAttribute('message', $tns->qualify($this->getOutput()->getName()));
      $node->appendChild($output_node);
    }

    return $node;
  }
}