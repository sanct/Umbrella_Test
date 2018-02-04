<?php
/**
 * Created by PhpStorm.
 * User: sanct
 * Date: 29.01.2018
 * Time: 13:40
 */

namespace AppBundle\Validator\Constraints;

use AppBundle\Utils\ShortUrl;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ActiveUrlValidator extends ConstraintValidator
{
	private $shortUrl;

	public function __construct(ShortUrl $short_url)
	{
		$this->shortUrl = $short_url;
	}

	public function validate( $value, Constraint $constraint )
	{
		if(!$this->shortUrl->isActiveUrl($value)) {
			$this->context->buildViolation($constraint->message)
		          ->setParameter('{{ string }}', $value)
		          ->addViolation();
		}
	}
}