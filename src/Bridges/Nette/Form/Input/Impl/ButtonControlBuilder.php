<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Input\Impl;

use Nette\Forms\Container;
use Nette\Forms\Controls\BaseControl;
use Tlapnet\Datus\Schema\FormInput;

class ButtonControlBuilder extends AbstractControlBuilder
{

	public function build(Container $form, FormInput $input): BaseControl
	{
		// Button has no validations, so disable it
		$input->setOption('allowValidations', FALSE);

		return $form->addButton($input->getId(), $input->getControl()->getLabel());
	}

}
