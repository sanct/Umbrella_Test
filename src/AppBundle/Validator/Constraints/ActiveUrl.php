<?php
/**
 * Created by PhpStorm.
 * User: sanct
 * Date: 29.01.2018
 * Time: 13:26
 */

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ActiveUrl extends Constraint
{
	public $message = 'The url {{ string }} inactive or counterfeit.';
}