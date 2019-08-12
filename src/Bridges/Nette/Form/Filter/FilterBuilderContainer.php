<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Filter;

use Tlapnet\Datus\Bridges\Nette\Form\Filter\Impl\IFilterBuilder;
use Tlapnet\Datus\Exception\Logical\InvalidStateException;

class FilterBuilderContainer
{

	/** @var IFilterBuilder[] */
	private $builders = [];

	public function add(string $name, IFilterBuilder $builder): void
	{
		$this->builders[$name] = $builder;
	}

	public function has(string $name): bool
	{
		return isset($this->builders[$name]);
	}

	public function get(string $name): IFilterBuilder
	{
		if (!isset($this->builders[$name])) {
			throw new InvalidStateException(sprintf('Undefined filter builder "%s"', $name));
		}

		return $this->builders[$name];
	}

}
