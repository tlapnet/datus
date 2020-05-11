<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Trigger;

use Nette\ComponentModel\Component;
use Nette\Forms\Controls\BaseControl;
use Tlapnet\Datus\Bridges\Nette\Form\Filter\FilterBuilderContainer;
use Tlapnet\Datus\Exception\Logical\InvalidStateException;
use Tlapnet\Datus\Schema\FormInput;

class InputFiltersTrigger
{

	/** @var FilterBuilderContainer */
	protected $filterBuilders;

	public function __construct(FilterBuilderContainer $filters)
	{
		$this->filterBuilders = $filters;
	}

	public function __invoke(FormInput $input, Component $component): Component
	{
		if (!($component instanceof BaseControl)) return $component;

		/** @var BaseControl $control */
		$control = $component;

		$filters = $input->getFilters();

		// Apply filters on Nette form controls
		if ($filters !== []) {
			foreach ($filters as $name => $args) {
				// Validate, there exists propel builder
				if (!$this->filterBuilders->has($name)) {
					throw new InvalidStateException(sprintf('Cannot apply "%s" filter', $name));
				}

				$control = $this->filterBuilders->get($name)->build($control, $input);
			}
		}

		return $control;
	}

}
