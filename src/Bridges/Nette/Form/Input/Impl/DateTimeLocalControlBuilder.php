<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Input\Impl;

use Nette\Forms\Container;
use Nette\Forms\Controls\BaseControl;
use Tlapnet\Datus\Bridges\Nette\Form\Input\Impl\Control\DateTime\DateTimeLocalControl;
use Tlapnet\Datus\Schema\FormInput;

class DateTimeLocalControlBuilder extends AbstractControlBuilder
{

	public function build(Container $form, FormInput $input): BaseControl
	{
		return $form[$input->getId()] = new DateTimeLocalControl($input->getControl()->getLabel());
	}

}
