<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Symfony\Validation\Builder\Impl;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Regex;
use Tlapnet\Datus\Exception\Logical\InvalidArgumentException;

class RegexConstraintBuilder extends AbstractConstraintBuilder
{

	/**
	 * @param mixed[] $params
	 */
	public function create(array $params): Constraint
	{
		if (!isset($params['pattern'])) {
			throw new InvalidArgumentException('Missing "pattern" parameter');
		}

		return new Regex([
			'pattern' => $params['pattern'],
		]);
	}

}
