<?php
/**
 * This file is part of the ckWsdlGenerator
 *
 * @package   ckWebServicePlugin
 * @author    Christian Kerl <christian-kerl@web.de>
 * @copyright Copyright (c) 2008, Christian Kerl
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @version   SVN: $Id$
 */

/**
 * The WSHeader annotation adds headers to webservice methods.
 *
 * @package    ckWsdlGenerator
 * @subpackage annotation
 * @author     Christian Kerl <christian-kerl@web.de>
 *
 * @Target("method")
 */
class WSHeader extends Annotation
{
  /**
   * The header name.
   *
   * @var string
   */
  public $name;

  /**
   * The type of the header.
   *
   * @var string
   */
  public $type;

  /**
   * (non-PHPdoc)
   * @see vendor/addendum/Annotation#checkConstraints()
   */
  protected function checkConstraints($target)
  {
    if(ckString::isNullOrEmpty($this->name) || ckString::isNullOrEmpty($this->type))
    {
      throw new InvalidArgumentException();
    }
  }
}