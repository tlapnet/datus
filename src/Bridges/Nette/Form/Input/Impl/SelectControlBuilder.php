<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Input\Impl;

use App\UI\Form\Control\SelectBox;
use Nette\Forms\Container;
use Tlapnet\Datus\Schema\FormInput;

class SelectControlBuilder extends AbstractControlBuilder
{

	public function build(Container $form, FormInput $input): SelectBox
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
