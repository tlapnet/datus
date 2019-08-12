<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form;

use Nette\Application\UI\Form;
use Nette\Application\UI\Form as NetteForm;

class SimpleFormBuilder extends AbstractFormBuilder
{

	/** @var string */
	protected $formClass = Form::class;

	public function setFormClass(string $formClass): void
	{
		$this->formClass = $formClass;
	}

	public function createForm(): NetteForm
	{
		return new $this->formClass();
	}

}
