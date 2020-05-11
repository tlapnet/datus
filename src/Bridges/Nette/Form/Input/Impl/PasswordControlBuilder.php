<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Input\Impl;

use Nette\Forms\Container;
use Nette\Forms\Controls\TextInput;
use Tlapnet\Datus\Schema\FormInput;

class PasswordControlBuilder extends AbstractControlBuilder
{

	public function build(Container $form, FormInput $input): TextInput
	{
		return $form->addPassword($input->getId(), $input->getControl()->getLabel());
	}

}
