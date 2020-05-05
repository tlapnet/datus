<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Symfony\Validation;

use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Tlapnet\Datus\Form\FormData;
use Tlapnet\Datus\Validation\IValidator;
use Tlapnet\Datus\Validation\ValidationResult;
use Tlapnet\Datus\Validation\ValidationResultBuilder;

class Validator implements IValidator
{

	/** @var Collection */
	private $constraints;

	/** @var ValidatorInterface */
	private $validator;

	public function __construct(Collection $constraints, ValidatorInterface $validator)
	{
		$this->constraints = $constraints;
		$this->validator = $validator;
	}

	public function validate(FormData $data): ValidationResult
	{
		/** @var ConstraintViolation[] $violations */
		$violations = $this->validator->validate($data->getValues(), $this->constraints);

		$errors = [];

		foreach ($violations as $violation) {
			// Strip [] from start & end
			$path = str_replace(['[', ']'], '', $violation->getPropertyPath());
			$errors[$path] = (string) $violation->getMessage();
		}

		return ValidationResultBuilder::of()
			->addInputErrors($errors)
			->build();
	}

}
