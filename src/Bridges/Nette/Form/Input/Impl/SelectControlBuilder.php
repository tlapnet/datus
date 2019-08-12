<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Input\Impl;

use Nette\Application\UI\Form;
use Nette\Forms\Controls\BaseControl;
use Tlapnet\Datus\Schema\FormInput;

class SelectControlBuilder extends AbstractControlBuilder
{

	public function build(Form $form, FormInput $input): BaseControl
	{
		$el = $form->addSelect($input->getId(), $input->getControl()->getLabel());

		$items = $input->getControl()->getOption('items', []);
		$useKeys = $input->getControl()->getOption('useKeys', true);

		if ($items !== []) {
			$el->setItems($items, $useKeys);
		}

		return $el;
	}

}
