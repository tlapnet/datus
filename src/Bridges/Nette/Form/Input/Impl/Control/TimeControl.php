<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Input\Impl\Control;

use Nette\Forms\Controls\TextInput;

class TimeControl extends TextInput
{

	public function __construct(?string $caption = null)
	{
		parent::__construct($caption);
		$this->control->setAttribute('type', 'time');
	}

	public function getValue(): ?string
	{
		if ($this->value === '' || $this->value === null) {
			return null;
		}

		// Expected official format H:i
		if (preg_match('#^(([0-1][0-9])|(2[0-3])):([0-5][0-9])$#', $this->value) !== 1) {
			$this->addError('Your browser doesn\'t support time field. Provide time in "HH:MM" format please.');
		}

		return $this->value;
	}

}
