<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Schema;

use Tlapnet\Datus\Exception\Logical\InvalidStateException;
use Tlapnet\Datus\Utils\TDecorators;
use Tlapnet\Datus\Utils\TOptions;

class Input
{

	use TOptions;
	use TDecorators;

	/** @var ?string */
	protected $description;

	/** @var mixed */
	protected $defaultValue;

	/** @var string[] */
	protected $filters = [];

	/** @var string[] */
	protected $validations = [];

	/** @var string[] */
	protected $conditions = [];

	/** @var Blueprint? backtrace */
	protected $blueprint;

	/** @var string */
	private $id;

	public function __construct(string $id)
	{
		$this->id = $id;
	}

	public function getId(): string
	{
		return $this->id;
	}

	public function getBlueprint(): ?Blueprint
	{
		return $this->blueprint;
	}

	public function setBlueprint(Blueprint $blueprint): void
	{
		$this->blueprint = $blueprint;
	}

	public function getDescription(): ?string
	{
		return $this->description;
	}

	public function setDescription(string $description): void
	{
		$this->description = $description;
	}

	/**
	 * @return mixed
	 */
	public function getDefaultValue()
	{
		return $this->defaultValue;
	}

	/**
	 * @param mixed $value
	 */
	public function setDefaultValue($value): void
	{
		$this->defaultValue = $value;
	}

	/**
	 * @return string[]
	 */
	public function getFilters(): array
	{
		return $this->filters;
	}

	/**
	 * @param string[] $filters
	 */
	public function setFilters(array $filters): void
	{
		$this->filters = $filters;
	}

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
	 * @return mixed[]
	 */
	public function getValidations(): array
	{
		return $this->validations;
	}

	/**
	 * @param string[] $validations
	 */
	public function setValidations(array $validations): void
	{
		$this->validations = $validations;
	}

	/**
	 * @return mixed[]
	 */
	public function getConditions(): array
	{
		return $this->conditions;
	}

	/**
	 * @param string[] $conditions
	 */
	public function setConditions(array $conditions): void
	{
		$this->conditions = $conditions;
	}

}
