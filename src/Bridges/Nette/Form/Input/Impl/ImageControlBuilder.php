<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Input\Impl;

use Nette\Forms\Container;
use Nette\Forms\Controls\ImageButton;
use Tlapnet\Datus\Schema\FormInput;

class ImageControlBuilder extends AbstractControlBuilder
{

	public function build(Container $form, FormInput $input): ImageButton
	{
		return $form->addImage($input->getId(), $input->getControl()->getLabel());
	}

}
