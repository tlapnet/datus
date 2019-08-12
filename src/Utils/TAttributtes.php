<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Utils;

use Tlapnet\Datus\Exception\Logical\InvalidStateException;

trait TAttributtes
{

	/** @var mixed[] */
	protected $attributes = [];

	/**
	 * @return mixed[]
	 */
	public function getAttributes(): array
	{
		return $this->attributes;
	}

	/**
	 * @param mixed[] $attributes
	 */
	public function setAttributes(array $attributes): void
	{
		$this->attributes = $attributes;
	}

	/**
	 * @param mixed[] $attributes
	 */
	public function addAttributes(array $attributes): void
	{
		$this->attributes = array_merge($this->attributes, $attributes);
	}

	public function hasAttribute(string $key): bool
	{
		return array_key_exists($key, $this->attributes);
	}

	/**
	 * @param mixed $default
	 * @return mixed
	 */
	public function getAttribute(string $key, $default = null)
	{
		if (!isset($this->attributes[$key])) {
			if (func_num_args() >= 2) {
				return $default;
			}

			throw new InvalidStateException(sprintf('Attribute "%s" not found', $key));
		}

		return $this->attributes[$key];
	}

	/**
	 * @param mixed $value
	 */
	public function setAttribute(string $key, $value): void
	{
		$this->attributes[$key] = $value;
	}

}
