<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Input\Impl;

use Nette\Application\UI\Form;
use Nette\Forms\Controls\BaseControl;
use Tlapnet\Datus\Schema\FormInput;

class ButtonControlBuilder extends AbstractControlBuilder
{

	public function build(Form $form, FormInput $input): BaseControl
	{
		// Button has no validations, so disable it
		$input->setOption('allowValidations', false);

		return $form->addButton($input->getId(), $input->getControl()->getLabel());
	}

}
