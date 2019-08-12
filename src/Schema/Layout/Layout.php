<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Schema\Layout;

use Tlapnet\Datus\Schema\FormBlueprint;
use Tlapnet\Datus\Schema\FormInput;

abstract class Layout
{

	/**
	 * @return FormInput[]
	 */
	abstract public function getInputs(FormBlueprint $blueprint): array;

}
