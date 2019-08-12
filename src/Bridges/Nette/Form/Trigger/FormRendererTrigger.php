<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Trigger;

use Latte\Engine;
use Nette\Application\UI\Form;
use Nette\Bridges\ApplicationLatte\ILatteFactory;
use Nette\Bridges\FormsLatte\FormMacros;
use Nette\Forms\IFormRenderer;
use Tlapnet\Datus\Bridges\Nette\Form\Renderer\RichRenderer;
use Tlapnet\Datus\Schema\FormBlueprint;
use Tlapnet\Datus\Schema\Layout\RichLayout;

class FormRendererTrigger
{

	/** @var ILatteFactory */
	protected $latteFactory;

	/** @var Engine|null */
	protected $latte;

	/** @var IFormRenderer */
	protected $renderer;

	public function __construct(ILatteFactory $latteFactory)
	{
		$this->latteFactory = $latteFactory;
	}

	public function __invoke(FormBlueprint $blueprint, Form $form): Form
	{
		$layout = $blueprint->getLayout();

		if ($layout instanceof RichLayout) {
			$form->setRenderer($this->createRenderer($blueprint, $form));
		}

		return $form;
	}

	protected function createRenderer(FormBlueprint $blueprint, Form $form): IFormRenderer
	{
		return new RichRenderer($blueprint, $this->getLatte());
	}

	protected function getLatte(): Engine
	{
		if ($this->latte === null) {
			$this->latte = $this->latteFactory->create();

			$this->latte->onCompile[] = function (Engine $latte): void {
				// Needed for {form}
				FormMacros::install($latte->getCompiler());
			};
		}

		return $this->latte;
	}

}
