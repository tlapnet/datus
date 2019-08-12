<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Utils;

use Tlapnet\Datus\Exception\Logical\InvalidStateException;

trait TRender
{

	/** @var mixed[] */
	protected $renders = [];

	/**
	 * @return string[]
	 */
	public function getRenders(): array
	{
		return $this->renders;
	}

	/**
	 * @param string[] $renders
	 */
	public function setRenders(array $renders): void
	{
		$this->renders = $renders;
	}

	/**
	 * @param mixed[] $renders
	 */
	public function addRenders(array $renders): void
	{
		$this->renders = array_merge($this->renders, $renders);
	}

	public function hasRender(string $key): bool
	{
		return array_key_exists($key, $this->renders);
	}

	/**
	 * @param mixed $default
	 * @return mixed
	 */
	public function getRender(string $key, $default = null)
	{
		if (!isset($this->renders[$key])) {
			if (func_num_args() >= 2) {
				return $default;
			}

			throw new InvalidStateException(sprintf('Render item "%s" not found', $key));
		}

		return $this->renders[$key];
	}

	/**
	 * @param mixed $value
	 */
	public function setRender(string $key, $value): void
	{
		$this->renders[$key] = $value;
	}

}
