<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Validation;

use Tlapnet\Datus\Schema\Blueprint;

interface IValidatorFactory
{

	public function create(Blueprint $blueprint): IValidator;

}
