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
class ckXsdArrayType extends ckXsdComplexType
{
  const ARRAY_SUFFIX = '[]';
  const NAME_PREFIX = 'ArrayOf';

  public static function create($name)
  {
    if(self::isArrayType($name))
    {
      $elementTypeName = substr($name, 0, -strlen(self::ARRAY_SUFFIX));
      $elementType = ckXsdType::get($elementTypeName);

      if(!is_null($elementType))
      {
        return new ckXsdArrayType(self::NAME_PREFIX.$elementTypeName, ckXsdNamespace::get('tns'), $elementType);
      }
    }

    return null;
  }

  public static function isArrayType($name)
  {
    return ckString::endsWith($name, self::ARRAY_SUFFIX);
  }

  /**
   * Enter description here...
   *
   * @var ckXsdType
   */
  protected $elementType;

  /**
   * Enter description here...
   *
   * @param ckXsdType $value
   */
  public function setElementType(ckXsdType $value)
  {
    $this->elementType = $value;
  }

  /**
   * Enter description here...
   *
   * @return ckXsdType
   */
  public function getElementType()
  {
    return $this->elementType;
  }

  protected function __construct($name = null, ckXsdNamespace $namespace = null, ckXsdType $elementType = null)
  {
    parent::__construct($name, $namespace);

    $this->setElementType($elementType);
  }

  public function serialize(DOMDocument $document)
  {
    $xsd = ckXsdNamespace::get('xsd');

    $node = $document->createElementNS($xsd->getUrl(), $xsd->qualify($this->getNodeName()));
    $node->setAttribute('name', $this->getName());

    $attr = $document->createElementNS($xsd->getUrl(), $xsd->qualify('attribute'));
    $attr->setAttribute('ref', 'soapenc:arrayType');
    $attr->setAttribute('wsdl:arrayType', $this->getElementType()->getQualifiedName().self::ARRAY_SUFFIX);

    $restriction = $document->createElementNS($xsd->getUrl(), $xsd->qualify('restriction'));
    $restriction->setAttribute('base', 'soapenc:Array');
    $restriction->appendChild($attr);

    $complexContent = $document->createElementNS($xsd->getUrl(), $xsd->qualify('complexContent'));
    $complexContent->appendChild($restriction);

    $node->appendChild($complexContent);

    return $node;
  }
}