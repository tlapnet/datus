<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Filter\Impl;

use Nette\Forms\Controls\BaseControl;
use Tlapnet\Datus\Schema\FormInput;

class LowercaseFilterBuilder extends AbstractFilterBuilder
{

	public function build(BaseControl $control, FormInput $input): BaseControl
	{
		$control->getRules()->addFilter(function ($s) {
			return $s
				? strtolower($s)
				: $s;
		});

		return $control;
	}

}
