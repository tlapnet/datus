<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Symfony\Validation\Builder\Impl;

use Symfony\Component\Validator\Constraint;
use Tlapnet\Datus\Bridges\Symfony\Validation\IValidatorBuilder;
use Tlapnet\Datus\Exception\Logical\InvalidStateException;

abstract class AbstractConstraintBuilder implements IValidatorBuilder
{

	/**
	 * @param mixed[] $params
	 */
	public function build(array $params): Constraint
	{
		$constraint = $this->create($params);
		$constraint = $this->decorate($constraint, $params);

		return $constraint;
	}

	/**
	 * @param mixed[] $params
	 */
	abstract protected function create(array $params): Constraint;

	/**
	 * @param mixed[] $params
	 */
	protected function decorate(Constraint $constraint, array $params = []): Constraint
	{
		if (isset($params['message'])) {
			if (!property_exists($constraint, 'message')) {
				throw new InvalidStateException(sprintf('Cannot set message to constraint "%s"', get_class($constraint)));
			}

			$constraint->message = $params['message'];
		}

		return $constraint;
	}

}
