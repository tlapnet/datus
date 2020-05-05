<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Input\Impl;

use Nette\Forms\Container;
use Nette\Forms\Controls\BaseControl;
use Tlapnet\Datus\Bridges\Nette\Form\Input\Impl\Control\TimeControl;
use Tlapnet\Datus\Schema\FormInput;

class TimeControlBuilder extends AbstractControlBuilder
{

	public function build(Container $form, FormInput $input): BaseControl
	{
		return $form[$input->getId()] = new TimeControl($input->getControl()->getLabel());
	}

}
