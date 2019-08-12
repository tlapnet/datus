<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Validation;

use Tlapnet\Datus\Form\FormData;

interface IValidator
{

	public function validate(FormData $data): ValidationResult;

}
