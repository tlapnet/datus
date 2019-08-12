<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form;

use Tlapnet\Datus\Exception\Logical\InvalidArgumentException;
use Tlapnet\Datus\Schema\Rawprint;

class FormRegistry
{

	/** @var Rawprint[] */
	protected $registry = [];

	public function add(string $name, Rawprint $rawprint): void
	{
		$this->registry[$name] = $rawprint;
	}

	public function get(string $name): Rawprint
	{
		if (!isset($this->registry[$name])) {
			throw new InvalidArgumentException(sprintf('Rawprint of "%s" not found. Did you register it?', $name));
		}

		return $this->registry[$name];
	}

}
