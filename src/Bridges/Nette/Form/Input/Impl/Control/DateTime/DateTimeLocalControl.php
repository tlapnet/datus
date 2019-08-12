<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Input\Impl\Control\DateTime;

class DateTimeLocalControl extends AbstractDateTimeControl
{

	public function __construct(?string $caption = null)
	{
		parent::__construct($caption);

		$this->controlType = 'datetime-local';
		$this->dateFormat = 'Y-m-d\TH:i';

		$this->control->setAttribute('type', $this->controlType);
	}

}
