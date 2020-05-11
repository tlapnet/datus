<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Input\Impl;

use Nette\ComponentModel\Component;
use Nette\Forms\Container;
use Tlapnet\Datus\Schema\FormInput;

interface IControlBuilder
{

	public function build(Container $form, FormInput $input): Component;

}
