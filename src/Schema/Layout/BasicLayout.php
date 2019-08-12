<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Schema\Layout;

use Tlapnet\Datus\Schema\FormBlueprint;
use Tlapnet\Datus\Schema\FormInput;

class BasicLayout extends Layout
{

	/**
	 * @return FormInput[]
	 */
	public function getInputs(FormBlueprint $blueprint): array
	{
		return $blueprint->getInputs();
	}

}
