<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Input\Impl;

use Nette\Forms\Container;
use Nette\Forms\Controls\BaseControl;
use Tlapnet\Datus\Schema\FormInput;

class HiddenControlBuilder extends AbstractControlBuilder
{

	public function build(Container $form, FormInput $input): BaseControl
	{
		return $form->addHidden($input->getId());
	}

}
