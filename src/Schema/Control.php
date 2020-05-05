<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Schema;

use Tlapnet\Datus\Utils\TAttributtes;
use Tlapnet\Datus\Utils\TOptions;

class Control
{

	use TOptions;
	use TAttributtes;

	/** @var ?string */
	protected $label;

	/** @var string */
	private $type;

	public function __construct(string $type)
	{
		$this->type = $type;
	}

	public function getType(): string
	{
		return $this->type;
	}

	public function getLabel(): ?string
	{
		return $this->label;
	}

	public function setLabel(string $label): void
	{
		$this->label = $label;
	}

}
