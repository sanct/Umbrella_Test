<?php
/**
 * Created by PhpStorm.
 * User: sanct
 * Date: 29.01.2018
 * Time: 17:13
 */

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Tests\Fixtures\ConstraintAValidator;

class ValidUrlValidator extends ConstraintAValidator
{
	public function validate($value, Constraint $constraint)
	{
		if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $value, $matches)) {
			$this->context->buildViolation($constraint->message)
				->setParameter('{{ string }}', $value)
				->addViolation();
		}
	}
}