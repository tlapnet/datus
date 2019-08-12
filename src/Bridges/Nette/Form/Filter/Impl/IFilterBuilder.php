<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Filter\Impl;

use Nette\Forms\Controls\BaseControl;
use Tlapnet\Datus\Schema\FormInput;

interface IFilterBuilder
{

	public function build(BaseControl $control, FormInput $input): BaseControl;

}
