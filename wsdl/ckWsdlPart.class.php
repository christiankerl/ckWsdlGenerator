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
 * ckWsdlPart represents a wsdl message part.
 *
 * @package    ckWsdlGenerator
 * @subpackage wsdl
 * @author     Christian Kerl <christian-kerl@web.de>
 */
class ckWsdlPart implements ckDOMSerializable
{
  /**
   * The name of the root node of the xml representation.
   */
  const ELEMENT_NAME = 'part';

  /**
   * The name of the part.
   *
   * @var string
   */
  protected $name;

  /**
   * The data type of the part.
   *
   * @var ckXsdType
   */
  protected $type;

  /**
   * Flag wether the part holds header data.
   *
   * @var boolean
   */
  protected $isHeader;

  /**
   * Gets the name of the part.
   *
   * @return string The name of the part
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * Sets the name of the part.
   *
   * @param string $value The name of the part
   */
  public function setName($value)
  {
    $this->name = $value;
  }

  /**
   * Gets the data type of the part.
   *
   * @return ckXsdType The data type of the part
   */
  public function getType()
  {
    return $this->type;
  }

  /**
   * Sets the data type of the part.
   *
   * @param ckXsdType $value The data type of the part
   */
  public function setType(ckXsdType $value)
  {
    $this->type = $value;
  }

  /**
   * Checks wether the part holds header data.
   *
   * @return boolean True, if the part holds header data, false otherwise
   */
  public function isHeader()
  {
    return $this->isHeader;
  }

  /**
   * Sets wether the part holds header data.
   *
   * @param boolean $value True, if the part holds header data, false otherwise
   */
  public function setIsHeader($value)
  {
    $this->isHeader = $value;
  }

  /**
   * @see ckDOMSerializable::getNodeName()
   */
  public function getNodeName()
  {
    return self::ELEMENT_NAME;
  }

  /**
   * Constructor initializing the part with a given name, a given data type and a flag, determining wether the part holds header data.
   *
   * @param string    $name     The name of the part
   * @param ckXsdType $type     The data type of the part
   * @param boolean   $isHeader True, if the part holds header data, false otherwise
   */
  public function __construct($name = null, ckXsdType $type = null, $isHeader = false)
  {
    $this->setName($name);
    $this->setType($type);
    $this->setIsHeader($isHeader);
  }

  /**
   * @see ckDOMSerializable::serialize()
   */
  public function serialize(DOMDocument $document)
  {
    $wsdl = ckXsdNamespace::get('wsdl');

    $node = $document->createElementNS($wsdl->getUrl(),$wsdl->qualify($this->getNodeName()));

    $node->setAttribute('name', $this->getName());

    $attr   = 'type';
    $suffix = '';

    if($this->getType() instanceof ckXsdComplexType && $this->isHeader())
    {
      $attr = 'element';
      $suffix = ckXsdComplexType::ELEMENT_SUFFIX;
    }

    $node->setAttribute($attr, $this->getType()->getQualifiedName().$suffix);

    return $node;
  }

  /**
   * Returns the string representation of the part, which equals the name of the part.
   *
   * @return string The string representation of the part
   */
  public function __toString()
  {
    return $this->getName();
  }
}