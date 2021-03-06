<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Form\Decorator;

use Tlapnet\Datus\Exception\Logical\InvalidStateException;
use Tlapnet\Datus\Form\Decorator\Input\IInputDecorator;

class InputDecoratorContainer
{

	/** @var IInputDecorator[] */
	private $decorators = [];

	public function add(string $name, IInputDecorator $decorator): void
	{
		$this->decorators[$name] = $decorator;
	}

	public function get(string $name): IInputDecorator
	{
		if (!isset($this->decorators[$name])) {
			throw new InvalidStateException(sprintf('Undefined decorator "%s"', $name));
		}

		return $this->decorators[$name];
	}

}
