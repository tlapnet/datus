<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Symfony\Validation;

use Symfony\Component\Validator\Constraint;

interface IValidatorBuilder
{

	/**
	 * @param mixed[] $params
	 */
	public function build(array $params): Constraint;

}
