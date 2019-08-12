<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Symfony\Validation\Constraints;

use Symfony\Component\Validator\Constraint;

class DateTimeGreaterThan extends Constraint
{

	/** @var string */
	public $message = 'The "{{ datetime1 }}" must be greater then "{{ datetime2 }}".';

	/** @var string */
	public $compareTo = 'NOW';

}
