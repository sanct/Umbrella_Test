<?php
/**
 * Created by PhpStorm.
 * User: sanct
 * Date: 29.01.2018
 * Time: 12:53
 */

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ContainsAlphanumeric extends Constraint
{
	public $message = 'The string {{ string }} contains an illegal character: it can only contain letters or numbers.';
}