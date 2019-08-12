<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Form;

use Tlapnet\Datus\Schema\FormBlueprint;

interface IFormBuilder
{

	/**
	 * @param mixed[] $args
	 */
	public function build(FormBlueprint $form, array $args = []): object;

}
