<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Symfony\Validation;

use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Optional;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\Validator\Validation;
use Tlapnet\Datus\Exception\Logical\InvalidStateException;
use Tlapnet\Datus\Schema\Blueprint;
use Tlapnet\Datus\Validation\IValidator;
use Tlapnet\Datus\Validation\IValidatorFactory;

class ValidatorFactory implements IValidatorFactory
{

	/** @var IValidatorBuilder[] */
	private $builders = [];

	public function addBuilder(string $name, IValidatorBuilder $builder): void
	{
		$this->builders[$name] = $builder;
	}

	public function create(Blueprint $blueprint): IValidator
	{
		$fields = [];

		foreach ($blueprint->getInputs() as $input) {
			$validators = $input->getValidations();

			// Skip inputs with no validators
			if (count($validators) <= 0) {
				continue;
			}

			// Skip if input is NOT enabled
			if ($input->getOption('enabled', true) === false) {
				continue;
			}

			// Skip if validation is disabled
			if ($input->getOption('validate', true) === false) {
				continue;
			}

			// List of constraints
			$list = [];

			// Iterate over all validators and build propel constraints
			foreach ($validators as $validator => $params) {
				// Skip @required validator, it's used later
				if ($validator === 'required') {
					continue;
				}

				// Check builder exists
				if (!isset($this->builders[$validator])) {
					throw new InvalidStateException(sprintf('Unknown "%s" validator. Did you register it?', $validator));
				}

				// Build constraint
				$list[] = $this->builders[$validator]->build($params);
			}

			// If there's @require validator, all constraints are required
			// otherwise they're optional
			if (array_key_exists('required', $validators)) {
				$fields[$input->getId()] = new Required($list);
			} else {
				$fields[$input->getId()] = new Optional($list);
			}
		}

		return new Validator(
			new Collection([
				'fields' => $fields,
				'allowExtraFields' => true,
			]),
			Validation::createValidator()
		);
	}

}
