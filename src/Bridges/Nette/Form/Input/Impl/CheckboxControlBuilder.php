<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Input\Impl;

use Nette\Forms\Container;
use Nette\Forms\Controls\Checkbox;
use Tlapnet\Datus\Schema\FormInput;

class CheckboxControlBuilder extends AbstractControlBuilder
{

	public function build(Container $form, FormInput $input): Checkbox
	{
		return $form->addCheckbox($input->getId(), $input->getControl()->getLabel());
	}

}
