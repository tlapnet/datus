<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Decorator;

class FormDecoratorManager
{

	/** @var FormDecoratorContainer */
	private $decorators;

	public function __construct(FormDecoratorContainer $decorators)
	{
		$this->decorators = $decorators;
	}

	public function get(string $name): IFormDecorator
	{
		return $this->decorators->get($name);
	}

}
