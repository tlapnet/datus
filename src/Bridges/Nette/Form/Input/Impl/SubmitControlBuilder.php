<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Input\Impl;

use Nette\Forms\Container;
use Nette\Forms\Controls\SubmitButton;
use Tlapnet\Datus\Schema\FormInput;

class SubmitControlBuilder extends AbstractControlBuilder
{

	public function build(Container $form, FormInput $input): SubmitButton
	{
		// Submit button has no validations, so disable it
		$input->setOption('allowValidations', false);

		return $form->addSubmit($input->getId(), $input->getControl()->getLabel());
	}

}
