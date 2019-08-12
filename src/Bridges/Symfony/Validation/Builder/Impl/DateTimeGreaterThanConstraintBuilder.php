<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Symfony\Validation\Builder\Impl;

use Symfony\Component\Validator\Constraint;
use Tlapnet\Datus\Bridges\Symfony\Validation\Constraints\DateTimeGreaterThan;

class DateTimeGreaterThanConstraintBuilder extends AbstractConstraintBuilder
{

	/**
	 * @param mixed[] $params
	 */
	public function create(array $params): Constraint
	{
		$options = [];

		if (isset($params['message'])) {
			$options['message'] = $params['message'];
		}

		if (isset($params['compareTo'])) {
			$options['compareTo'] = $params['compareTo'];
		}

		return new DateTimeGreaterThan($options);
	}

}
