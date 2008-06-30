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
class ckWsdlSoapBindingDecorator extends ckWsdlBindingDecorator
{
  public abstract function serialize(DOMDocument $document)
  {
    return $this->getOperation()->serialize($document);
  }
}