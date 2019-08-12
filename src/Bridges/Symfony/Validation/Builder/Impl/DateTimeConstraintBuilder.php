<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Symfony\Validation\Builder\Impl;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\DateTime;
use Tlapnet\Datus\Exception\Logical\InvalidArgumentException;

class DateTimeConstraintBuilder extends AbstractConstraintBuilder
{

	/**
	 * @param mixed[] $params
	 */
	public function create(array $params): Constraint
	{
		if (!isset($params['format'])) {
			throw new InvalidArgumentException('Missing "format" parameter');
		}

		return new DateTime([
			'format' => $params['format'],
		]);
	}

}
