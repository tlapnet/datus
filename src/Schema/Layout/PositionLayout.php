<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Schema\Layout;

use Tlapnet\Datus\Schema\FormBlueprint;
use Tlapnet\Datus\Schema\FormInput;
use Tlapnet\Datus\Schema\Input;

class PositionLayout extends Layout
{

	/** @var int */
	private $delimiter = 10;

	/** @var FormInput[][] */
	private $cached = [];

	/**
	 * @param mixed[] $options
	 */
	public function __construct(array $options = [])
	{
		if (isset($options['delimiter'])) {
			$this->delimiter = $options['delimiter'];
		}
	}

	/**
	 * @return FormInput[]
	 */
	public function getInputs(FormBlueprint $blueprint): array
	{
		$hash = spl_object_hash($blueprint) . '-' . count($blueprint->getInputs());

		if (!isset($this->cached[$hash])) {
			$this->cached[$hash] = $this->calculate($blueprint);
		}

		return $this->cached[$hash];
	}

	/**
	 * @return FormInput[]
	 */
	protected function calculate(FormBlueprint $blueprint): array
	{
		$inputs = $blueprint->getInputs();
		$positions = [];

		foreach ($inputs as $name => $input) {
			$position = $input->getControl()->getOption('position', null);

			// Use predefined position or calculate default position
			if ($position !== null) {
				$positions[$name] = $position;
			} else {
				$positions[$name] = count($positions) * $this->delimiter;
			}
		}

		// Sort by positions
		usort($inputs, function (Input $i1, Input $i2) use ($positions) {
			return $positions[$i1->getId()] > $positions[$i2->getId()];
		});

		return $inputs;
	}

}
