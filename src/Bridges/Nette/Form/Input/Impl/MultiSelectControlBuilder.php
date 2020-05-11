<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Input\Impl;

use Nette\Forms\Container;
use Nette\Forms\Controls\MultiSelectBox;
use Tlapnet\Datus\Schema\FormInput;

class MultiSelectControlBuilder extends AbstractControlBuilder
{

	public function build(Container $form, FormInput $input): MultiSelectBox
	{
		$el = $form->addMultiSelect($input->getId(), $input->getControl()->getLabel());

		$items = $input->getControl()->getOption('items', []);
		$useKeys = $input->getControl()->getOption('useKeys', true);

		if ($items !== []) {
			$el->setItems($items, $useKeys);
		}

		return $el;
	}

}
