<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Decorator;

use Nette\Application\UI\Form;

interface IFormDecorator
{

	public function apply(Form $form): void;

}
