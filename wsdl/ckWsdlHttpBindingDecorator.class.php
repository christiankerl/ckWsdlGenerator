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
 * ckWsdlHttpBindingDecorator provides methods to decorate a wsdl binding definition with data specific for the http protocol.
 *
 * @package    ckWsdlGenerator
 * @subpackage wsdl
 * @author     Christian Kerl <christian-kerl@web.de>
 */
class ckWsdlHttpBindingDecorator extends ckWsdlBindingDecorator
{
  /**
   * @see ckDOMSerializable::serialize()
   */
  public function serialize(DOMDocument $document)
  {
    return null;
  }
}