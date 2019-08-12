<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Form\Decorator\Input;

use Tlapnet\Datus\Exception\Logical\InvalidStateException;
use Tlapnet\Datus\Schema\FormInput;
use Tlapnet\Datus\Schema\Input;

abstract class AbstractFormInputDecorator implements IInputDecorator
{

	public function apply(Input $input): void
	{
		if (!($input instanceof FormInput)) {
			throw new InvalidStateException(sprintf('Only input of type "%s" is supported', FormInput::class));
		}

		$this->applyInput($input);
	}

	abstract public function applyInput(FormInput $input): void;

}
