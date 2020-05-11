<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Input\Impl;

use Nette\Forms\Container;
use Nette\Forms\Controls\UploadControl;
use Tlapnet\Datus\Schema\FormInput;

class MultiUploadControlBuilder extends AbstractControlBuilder
{

	public function build(Container $form, FormInput $input): UploadControl
	{
		return $form->addMultiUpload($input->getId(), $input->getControl()->getLabel());
	}

}
