<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Decorator;

class InputDecoratorManager
{

	/** @var InputDecoratorContainer */
	private $decorators;

	public function __construct(InputDecoratorContainer $decorators)
	{
		$this->decorators = $decorators;
	}

	public function get(string $name): IInputDecorator
	{
		return $this->decorators->get($name);
	}

}
