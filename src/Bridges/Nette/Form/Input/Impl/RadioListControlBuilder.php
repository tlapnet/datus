<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Input\Impl;

use Nette\Forms\Container;
use Nette\Forms\Controls\RadioList;
use Tlapnet\Datus\Schema\FormInput;

class RadioListControlBuilder extends AbstractControlBuilder
{

	public function build(Container $form, FormInput $input): RadioList
	{
		$el = $form->addRadioList($input->getId(), $input->getControl()->getLabel());

		$items = $input->getControl()->getOption('items', []);
		$useKeys = $input->getControl()->getOption('useKeys', true);

		if ($items !== []) {
			$el->setItems($items, $useKeys);
		}

		return $el;
	}

}
