<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Utils;

use Tlapnet\Datus\Exception\Logical\InvalidStateException;

trait TDecorators
{

	/** @var mixed[] */
	protected $decorators = [];

	/**
	 * @return mixed[]
	 */
	public function getDecorators(): array
	{
		return $this->decorators;
	}

	/**
	 * @param mixed[] $decorators
	 */
	public function setDecorators(array $decorators): void
	{
		$this->decorators = $decorators;
	}

	/**
	 * @param mixed[] $decorators
	 */
	public function addDecorators(array $decorators): void
	{
		$this->decorators = array_merge($this->decorators, $decorators);
	}

	public function hasDecorator(string $key): bool
	{
		return array_key_exists($key, $this->decorators);
	}

	/**
	 * @param mixed $default
	 * @return mixed
	 */
	public function getDecorator(string $key, $default = null)
	{
		if (!isset($this->decorators[$key])) {
			if (func_num_args() >= 2) {
				return $default;
			}

			throw new InvalidStateException(sprintf('Decorator "%s" not found', $key));
		}

		return $this->decorators[$key];
	}

	/**
	 * @param mixed $value
	 */
	public function setDecorator(string $key, $value): void
	{
		$this->decorators[$key] = $value;
	}

}
