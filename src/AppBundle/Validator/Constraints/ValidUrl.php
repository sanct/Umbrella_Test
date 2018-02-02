<?php
/**
 * Created by PhpStorm.
 * User: sanct
 * Date: 29.01.2018
 * Time: 17:12
 */

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ValidUrl extends Constraint
{
	public $message = 'The url {{ string }} invalid.';
}