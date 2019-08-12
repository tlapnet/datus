<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Symfony\Validation\Builder;

use Tlapnet\Datus\Bridges\Symfony\Validation\IValidatorBuilder;
use Tlapnet\Datus\Exception\Logical\InvalidStateException;

class ValidationBuilderContainer
{

	/** @var IValidatorBuilder[] */
	private $builders = [];

	public function add(string $name, IValidatorBuilder $builder): void
	{
		$this->builders[$name] = $builder;
	}

	public function get(string $name): IValidatorBuilder
	{
		if (!isset($this->builders[$name])) {
			throw new InvalidStateException(sprintf('Undefined validation builder "%s"', $name));
		}

		return $this->builders[$name];
	}

}
