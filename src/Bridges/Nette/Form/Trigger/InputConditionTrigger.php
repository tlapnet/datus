<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Trigger;

use Nette\Utils\Arrays;
use Tlapnet\Datus\Exception\Logical\InvalidStateException;
use Tlapnet\Datus\Schema\FormInput;
use Tlapnet\Datus\Utils\FormInputCorrector;

class InputConditionTrigger
{

	public function __invoke(FormInput $input): FormInput
	{
		// No conditions on input
		if ($input->getConditions() === []) {
			return $input;
		}

		$blueprint = $input->getBlueprint();

		// Input is not attached to blueprint
		if ($blueprint === null) {
			return $input;
		}

		// No props given
		if (!$blueprint->hasOption('props')) {
			return $input;
		}

		// Apply conditions
		$this->apply($input);

		return $input;
	}

	protected function apply(FormInput $input): void
	{
		// Input is not attached to blueprint
		if ($input->getBlueprint() === null) {
			throw new InvalidStateException('Input must be attached to Blueprint');
		}

		$props = $input->getBlueprint()->getOption('props');

		foreach ($input->getConditions() as $id => $condition) {
			// Validate condition key
			if (!isset($condition['condition'])) {
				throw new InvalidStateException(sprintf('Key "%s.condition" is required', $id));
			}

			// Validate condition
			if (!is_array($condition['condition']) || count($condition['condition']) !== 3) {
				throw new InvalidStateException('Only array condition [variable, comparator, value] is supported');
			}

			// Destruct array into variables
			[$variable, $comparator, $value] = $condition['condition'];

			// Resolve condition
			$res = $this->resolve($variable, $comparator, $value, $props);

			// On truthy condition, modify control
			if ($res) {
				$this->modify($input, $condition);
			}
		}
	}

	/**
	 * @param mixed $value
	 * @param mixed[] $props
	 */
	protected function resolve(string $variable, string $comparator, $value, array $props): bool
	{
		if ($comparator === '=') {
			$realValue = Arrays::get($props, explode('.', $variable), null);

			return $realValue === $value;
		}

		throw new InvalidStateException(sprintf('Unsupported condition: %s%s%s', $variable, $comparator, $value));
	}

	/**
	 * @param mixed[] $condition
	 */
	protected function modify(FormInput $input, array $condition): void
	{
		// Don't include condition, it's useless
		unset($condition['condition']);

		// Perform corrections
		FormInputCorrector::perform($input, $condition);
	}

}
