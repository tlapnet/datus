<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Schema\Layout;

use Tlapnet\Datus\Utils\TRender;

class Section
{

	use TRender;

	/** @var Input[] */
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
	 * @return Input[]
	 */
	public function getInputs(): array
	{
		return $this->inputs;
	}

	/**
	 * @param Input[] $inputs
	 */
	public function setInputs(array $inputs): void
	{
		$this->inputs = $inputs;
	}

}
