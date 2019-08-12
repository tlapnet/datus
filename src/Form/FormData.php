<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Form;

use Tlapnet\Datus\Schema\Blueprint;
use Tlapnet\Datus\Schema\FormBlueprint;

class FormData
{

	/** @var FormBlueprint */
	private $blueprint;

	/** @var mixed[] */
	private $values;

	/**
	 * @param mixed[] $values
	 */
	public function __construct(FormBlueprint $blueprint, array $values)
	{
		$this->blueprint = $blueprint;
		$this->values = $values;
	}

	public function getBlueprint(): Blueprint
	{
		return $this->blueprint;
	}

	/**
	 * @return mixed[]
	 */
	public function getValues(): array
	{
		return $this->values;
	}

}
