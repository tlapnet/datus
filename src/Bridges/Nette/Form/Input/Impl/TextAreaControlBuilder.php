<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Input\Impl;

use Nette\Forms\Container;
use Nette\Forms\Controls\TextArea;
use Tlapnet\Datus\Schema\FormInput;

class TextAreaControlBuilder extends AbstractControlBuilder
{

	public function build(Container $form, FormInput $input): TextArea
	{
		return $form->addTextArea($input->getId(), $input->getControl()->getLabel());
	}

}
