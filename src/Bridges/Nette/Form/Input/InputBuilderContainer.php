<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Input;

use Tlapnet\Datus\Bridges\Nette\Form\Input\Impl\IControlBuilder;
use Tlapnet\Datus\Exception\Logical\InvalidStateException;

class InputBuilderContainer
{

	/** @var IControlBuilder[] */
	private $builders = [];

	public function add(string $name, IControlBuilder $builder): void
	{
		$this->builders[$name] = $builder;
	}

	public function has(string $name): bool
	{
		return isset($this->builders[$name]);
	}

	public function get(string $name): IControlBuilder
	{
		if (!isset($this->builders[$name])) {
			throw new InvalidStateException(sprintf('Undefined control builder "%s"', $name));
		}

		return $this->builders[$name];
	}

}
