<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Input\Impl\Control\DateTime;

use DateTimeImmutable;

class DateControl extends AbstractDateTimeControl
{

	public function __construct(?string $caption = null)
	{
		parent::__construct($caption);

		$this->controlType = 'date';
		$this->dateFormat = 'Y-m-d';

		$this->control->setAttribute('type', $this->controlType);
	}

	public function getValue(): ?DateTimeImmutable
	{
		$value = parent::getValue();

		if ($value !== null) {
			// Set midnight so the limit dates (min & max) pass the :RANGE validation rule
			// Min max not yet implemented in Datus nor in AbstractDateTimeControl
			return $value->setTime(0, 0, 0, 0);
		}

		return $value;
	}

}
