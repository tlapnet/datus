<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Trigger;

use Nette\ComponentModel\Component;
use Nette\Forms\Controls\BaseControl;
use Tlapnet\Datus\Schema\FormInput;

class InputBasicTrigger
{

	public function __invoke(FormInput $input, Component $component): Component
	{
		if (!($component instanceof BaseControl)) return $component;

		/** @var BaseControl $control */
		$control = $component;

		// Mark all controls as not-required (it's needed for filters later)
		$control->setRequired(false);

		// Fill default value
		if ($input->getDefaultValue() !== null) {
			$control->setDefaultValue($input->getDefaultValue());
		}

		$attributes = $input->getControl()->getAttributes();

		// Fill HTML attributes
		if ($attributes !== []) {
			foreach ($attributes as $name => $value) {
				$control->setHtmlAttribute($name, $value);
			}

			// Nette-form specific
			if ($input->getControl()->hasAttribute('disabled')) {
				$control->setDisabled($input->getControl()->getAttribute('disabled'));
			}
		}

		return $control;
	}

}
