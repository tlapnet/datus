<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Decorator;

use Nette\Forms\Controls\BaseControl;
use Tlapnet\Datus\Schema\FormInput;

interface IInputDecorator
{

	public function apply(FormInput $input, BaseControl $control): void;

}
