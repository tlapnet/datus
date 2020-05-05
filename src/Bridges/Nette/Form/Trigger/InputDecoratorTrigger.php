<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Trigger;

use Nette\Forms\Controls\BaseControl;
use Tlapnet\Datus\Bridges\Nette\Form\Decorator\InputDecoratorManager;
use Tlapnet\Datus\Schema\FormInput;

class InputDecoratorTrigger
{

	/** @var InputDecoratorManager */
	protected $inputDecoratorManager;

	public function __construct(InputDecoratorManager $inputDecoratorManager)
	{
		$this->inputDecoratorManager = $inputDecoratorManager;
	}

	public function __invoke(FormInput $input, BaseControl $control): FormInput
	{
		// Apply decorators on Blueprint's inputs
		// It's before Nette form controls are created
		// because we need to decorate input's data

		// Cannot be used in @input.build.after event
		// because it's decorates attributes/options etc
		// which are set in InputBasicTrigger etc.

		foreach ($input->getDecorators() as $name => $args) {
			$this->inputDecoratorManager->get($name)->apply($input, $control);
		}

		return $input;
	}

}
