<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Input\Impl;

use Nette\Forms\Container;
use Tlapnet\Datus\Schema\FormInput;

class ContainerControlBuilder extends AbstractControlBuilder
{

	public function build(Container $form, FormInput $input): Container
	{
		return $form->addContainer($input->getId());
	}

}
