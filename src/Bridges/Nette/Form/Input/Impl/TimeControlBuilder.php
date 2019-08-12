<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Input\Impl;

use Nette\Application\UI\Form;
use Nette\Forms\Controls\BaseControl;
use Tlapnet\Datus\Bridges\Nette\Form\Input\Impl\Control\TimeControl;
use Tlapnet\Datus\Schema\FormInput;

class TimeControlBuilder extends AbstractControlBuilder
{

	public function build(Form $form, FormInput $input): BaseControl
	{
		return $form[$input->getId()] = new TimeControl($input->getControl()->getLabel());
	}

}
