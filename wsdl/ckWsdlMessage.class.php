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
 * ckWsdlMessage represents a wsdl message.
 *
 * @package    ckWsdlGenerator
 * @subpackage wsdl
 * @author     Christian Kerl <christian-kerl@web.de>
 */
class ckWsdlMessage implements ckDOMSerializable
{
  /**
   * The name of the root node of the xml representation.
   */
  const ELEMENT_NAME = 'message';

  /**
   * The name of the message.
   *
   * @var string
   */
  protected $name;

  /**
   * An array containing all message parts.
   *
   * @var array
   */
  protected $parts = array();

  /**
   * Gets the name of the message.
   *
   * @return string The name of the message
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * Sets the name of the message.
   *
   * @param string $value The name of the message
   */
  public function setName($value)
  {
    $this->name = $value;
  }

  /**
   * Gets an array containing all message parts.
   *
   * @return array An array of message parts
   */
  public function getParts()
  {
    return $this->parts;
  }

  /**
   * Gets an array containing all message parts, which hold header data.
   *
   * @return array An array of message parts
   */
  public function getHeaderParts()
  {
    return array_filter($this->getParts(), array($this, 'isHeaderPart'));
  }

  /**
   * Gets an array containing all message parts, which hold non header data.
   *
   * @return array An array of message parts
   */
  public function getBodyParts()
  {
    return array_filter($this->getParts(), array($this, 'isBodyPart'));
  }

  /**
   * Adds a part to this message.
   *
   * @param ckWsdlPart $part A message part
   */
  public function addPart(ckWsdlPart $part)
  {
    $this->parts[] = $part;
  }

  /**
   * @see ckDOMSerializable::getNodeName()
   */
  public function getNodeName()
  {
    return self::ELEMENT_NAME;
  }

  /**
   * Constructor initializing the message with a given name.
   *
   * @param string $name The name of the message
   */
  public function __construct($name)
  {
    $this->setName($name);
  }

  /**
   * @see ckDOMSerializable::serialize()
   */
  public function serialize(DOMDocument $document)
  {
    $wsdl = ckXsdNamespace::get('wsdl');

    $node = $document->createElementNS($wsdl->getUrl(), $wsdl->qualify($this->getNodeName()));

    $node->setAttribute('name', $this->getName());

    foreach($this->getParts() as $part)
    {
      $node->appendChild($part->serialize($document));
    }

    return $node;
  }

  /**
   * Checks wether the given message part holds header data.
   *
   * @param ckWsdlPart $input A message part to check
   *
   * @return boolean True, if the message part holds header data, false otherwise
   */
  private function isHeaderPart(ckWsdlPart $input)
  {
    return $input->isHeader();
  }

  /**
   * Checks wether the given message part holds non header data.
   *
   * @param ckWsdlPart $input A message part to check
   *
   * @return boolean True, if the message part holds non header data, false otherwise
   */
  private function isBodyPart(ckWsdlPart $input)
  {
    return !$input->isHeader();
  }
}