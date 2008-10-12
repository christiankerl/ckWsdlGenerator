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
 * ckDOMSerializable provides methods to make an object serializable to xml.
 *
 * @package    ckWsdlGenerator
 * @author     Christian Kerl <christian-kerl@web.de>
 */
interface ckDOMSerializable
{
  /**
   * Gets the name of the root node of the objects xml representation.
   *
   * @return string The node name
   */
  public function getNodeName();

  /**
   * Serializes the object in the context of a given xml document.
   *
   * @param DOMDocument $document A xml document used to create node objects
   *
   * @return DOMNode The xml representation of the object
   */
  public function serialize(DOMDocument $document);
}