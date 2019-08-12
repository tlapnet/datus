<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Form\Decorator\Input;

use Tlapnet\Datus\Schema\Input;

interface IInputDecorator
{

	public function apply(Input $input): void;

}
