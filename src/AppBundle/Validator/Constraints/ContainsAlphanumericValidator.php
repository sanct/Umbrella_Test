<?php
/**
 * Created by PhpStorm.
 * User: sanct
 * Date: 29.01.2018
 * Time: 13:08
 */

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ContainsAlphanumericValidator extends ConstraintValidator
{
	public function validate($value, Constraint $constraint)
	{
		if (!preg_match('/^[a-zA-Z0-9]+$/', $value, $matches)) {
			$this->context->buildViolation($constraint->message)
		          ->setParameter('{{ string }}', $value)
		          ->addViolation();
		}
	}
}