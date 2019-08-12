<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Decorator;

use Tlapnet\Datus\Bridges\Nette\Form\Decorator\Form\IFormDecorator;
use Tlapnet\Datus\Exception\Logical\InvalidStateException;

class FormDecoratorContainer
{

	/** @var IFormDecorator[] */
	private $decorators = [];

	public function add(string $name, IFormDecorator $decorator): void
	{
		$this->decorators[$name] = $decorator;
	}

	public function get(string $name): IFormDecorator
	{
		if (!isset($this->decorators[$name])) {
			throw new InvalidStateException(sprintf('Undefined decorator "%s"', $name));
		}

		return $this->decorators[$name];
	}

}
