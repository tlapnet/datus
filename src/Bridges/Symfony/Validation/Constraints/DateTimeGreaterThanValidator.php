<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Symfony\Validation\Constraints;

use Nette\Utils\DateTime;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Throwable;
use Tlapnet\Datus\Utils\DateTimeTools;

class DateTimeGreaterThanValidator extends ConstraintValidator
{

	/**
	 * @param mixed $value
	 * @param DateTimeGreaterThan $constraint
	 */
	public function validate($value, Constraint $constraint): void
	{
		if ($value === null || $value === '') {
			return;
		}

		try {
			$compareFrom = DateTime::from($value);
			$compareTo = DateTime::from(
				$constraint->compareTo === 'NOW' ? '' : $constraint->compareTo
			);

			if (!($compareFrom >= $compareTo)) {
				$this->context->buildViolation($constraint->message)
					->setParameter('{{ datetime1 }}', $compareFrom->format('d.m.Y H:i:s'))
					->setParameter('{{ datetime2 }}', $compareTo->format('d.m.Y H:i:s'))
					->addViolation();
			}
		} catch (Throwable $e) {
			$this->context->buildViolation('Invalid input "{{ input }}" into DateTimeGreaterThanValidator')
				->setParameter('{{ input }}', DateTimeTools::ensureFormat($value))
				->addViolation();
		}
	}

}
