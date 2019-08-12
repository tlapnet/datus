<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Trigger;

use Nette\Application\UI\Form;
use Tlapnet\Datus\Bridges\Nette\Form\Decorator\FormDecoratorManager;
use Tlapnet\Datus\Schema\FormBlueprint;

class FormDecoratorTrigger
{

	/** @var FormDecoratorManager */
	protected $formDecoratorManager;

	public function __construct(FormDecoratorManager $formDecoratorManager)
	{
		$this->formDecoratorManager = $formDecoratorManager;
	}

	public function __invoke(FormBlueprint $blueprint, Form $form): Form
	{
		// Apply form decorators on real Nette form,
		// it's triggered after form is completed.
		foreach ($blueprint->getDecorators() as $name => $args) {
			$this->formDecoratorManager->get($name)->apply($form);
		}

		return $form;
	}

}
