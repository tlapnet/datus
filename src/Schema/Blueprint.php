<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Schema;

use Tlapnet\Datus\Exception\Logical\InvalidStateException;
use Tlapnet\Datus\Utils\TOptions;

class Blueprint
{

	use TOptions;

	/** @var Input[]|FormInput[] */
	protected $inputs = [];

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

	/**
	 * @return Input[]|FormInput[]
	 */
	public function getInputs(): array
	{
		return $this->inputs;
	}

	/**
	 * @return Input|FormInput
	 */
	public function getInput(string $id): Input
	{
		if (!isset($this->inputs[$id])) {
			throw new InvalidStateException(sprintf('Input "%s" not found', $id));
		}

		return $this->inputs[$id];
	}

	/**
	 * @param Input[]|FormInput[] $inputs
	 */
	public function addInputs(array $inputs): void
	{
		foreach ($inputs as $input) {
			$this->addInput($input);
		}
	}

	public function addInput(Input $input): void
	{
		$input->setBlueprint($this);

		$this->inputs[$input->getId()] = $input;
	}

}
