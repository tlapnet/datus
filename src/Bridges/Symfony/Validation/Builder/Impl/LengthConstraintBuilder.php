<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Symfony\Validation\Builder\Impl;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Length;
use Tlapnet\Datus\Exception\Logical\InvalidArgumentException;

class LengthConstraintBuilder extends AbstractConstraintBuilder
{

	/**
	 * @param mixed[] $params
	 */
	public function create(array $params): Constraint
	{
		if (!isset($params['min'])) {
			throw new InvalidArgumentException('Missing "min" parameter');
		}

		return new Length(['min' => $params['min']]);
	}

}
