<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Utils;

use Tlapnet\Datus\Exception\Logical\InvalidStateException;

trait TOptions
{

	/** @var mixed[] */
	protected $options = [];

	/**
	 * @return string[]
	 */
	public function getOptions(): array
	{
		return $this->options;
	}

	/**
	 * @param string[] $options
	 */
	public function setOptions(array $options): void
	{
		$this->options = $options;
	}

	/**
	 * @param mixed[] $options
	 */
	public function addOptions(array $options): void
	{
		$this->options = array_merge($this->options, $options);
	}

	public function hasOption(string $key): bool
	{
		return array_key_exists($key, $this->options);
	}

	/**
	 * @param mixed $default
	 * @return mixed
	 */
	public function getOption(string $key, $default = null)
	{
		if (!isset($this->options[$key])) {
			if (func_num_args() >= 2) {
				return $default;
			}

			throw new InvalidStateException(sprintf('Option "%s" not found', $key));
		}

		return $this->options[$key];
	}

	/**
	 * @param mixed $value
	 */
	public function setOption(string $key, $value): void
	{
		$this->options[$key] = $value;
	}

}
