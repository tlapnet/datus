<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Schema;

use Tlapnet\Datus\Exception\Logical\InvalidStateException;

class FormInput extends Input
{

	public const CONTAINER = 'container';

	/** @var Control|null */
	protected $control;

	public function getControl(): Control
	{
		if ($this->control === null) {
			throw new InvalidStateException('Control is not attached on input');
		}

		return $this->control;
	}

	public function setControl(Control $control): void
	{
		$this->control = $control;
	}

}
