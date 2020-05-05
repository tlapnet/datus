<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Schema;

use ArrayAccess;
use Tlapnet\Datus\Exception\Logical\InvalidArgumentException;

/**
 * @implements ArrayAccess<string,mixed>
 */
class Rawprint implements ArrayAccess
{

	/** @var mixed */
	protected $raw = [
		'layout' => null,
		'modes' => [],
	];

	/**
	 * @param mixed[] $raw
	 */
	public function __construct(array $raw = [])
	{
		$this->raw = array_merge($this->raw, $raw);
	}

	/**
	 * @param mixed[] $mode
	 */
	public function addMode(array $mode): void
	{
		$this->raw['modes'][] = $mode;
	}

	/**
	 * @return mixed[]
	 */
	public function getRaw(): array
	{
		return $this->raw;
	}

	/**
	 * ArrayAccess *************************************************************
	 */

	/**
	 * @param mixed $offset
	 */
	public function offsetExists($offset): bool
	{
		return array_key_exists($offset, $this->raw);
	}

	/**
	 * @param mixed $offset
	 * @return mixed
	 */
	public function offsetGet($offset)
	{
		if (!$this->offsetExists($offset)) {
			throw new InvalidArgumentException(sprintf('Key "%s" does not exist', $offset));
		}

		return $this->raw[$offset];
	}

	/**
	 * @param mixed $offset
	 * @param mixed $value
	 */
	public function offsetSet($offset, $value): void
	{
		$this->raw[$offset] = $value;
	}

	/**
	 * @param mixed $offset
	 */
	public function offsetUnset($offset): void
	{
		unset($this->raw[$offset]);
	}

}
