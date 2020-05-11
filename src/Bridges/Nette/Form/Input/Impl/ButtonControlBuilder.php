<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Input\Impl;

use Nette\Forms\Container;
use Nette\Forms\Controls\Button;
use Tlapnet\Datus\Schema\FormInput;

class ButtonControlBuilder extends AbstractControlBuilder
{

	public function build(Container $form, FormInput $input): Button
	{
		// Button has no validations, so disable it
		$input->setOption('allowValidations', false);

		return $form->addButton($input->getId(), $input->getControl()->getLabel());
	}

}
