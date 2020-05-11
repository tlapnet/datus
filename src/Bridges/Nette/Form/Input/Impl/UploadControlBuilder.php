<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Input\Impl;

use Nette\Forms\Container;
use Nette\Forms\Controls\UploadControl;
use Tlapnet\Datus\Schema\FormInput;

class UploadControlBuilder extends AbstractControlBuilder
{

	public function build(Container $form, FormInput $input): UploadControl
	{
		return $form->addUpload($input->getId(), $input->getControl()->getLabel());
	}

}
