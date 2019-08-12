<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Renderer;

use Latte\Engine;
use Nette\Bridges\ApplicationLatte\Template;
use Nette\Forms\Form;
use Nette\Forms\IFormRenderer;
use Tlapnet\Datus\Schema\FormBlueprint;

class RichRenderer implements IFormRenderer
{

	/** @var FormBlueprint */
	protected $blueprint;

	/** @var Engine */
	protected $latte;

	/** @var mixed[] */
	protected $parameters = [];

	/** @var mixed[] */
	protected $options = [
		'template' => __DIR__ . '/templates/rich.latte',
	];

	/** @var Template */
	protected $template;

	public function __construct(FormBlueprint $blueprint, Engine $latte)
	{
		$this->blueprint = $blueprint;
		$this->latte = $latte;
	}

	/**
	 * @param mixed[] $parameters
	 */
	public function setParameters(array $parameters): void
	{
		$this->parameters = $parameters;
	}

	/**
	 * @param mixed[] $parameters
	 */
	public function addParameters(array $parameters): void
	{
		$this->parameters = array_merge($this->parameters, $parameters);
	}

	/**
	 * @param mixed[] $options
	 */
	public function setOptions(array $options): void
	{
		$this->options = $options;
	}

	/**
	 * @param mixed[] $options
	 */
	public function addOptions(array $options): void
	{
		$this->options = array_merge($this->options, $options);
	}

	public function render(Form $form): string
	{
		$this->template = new Template($this->latte);

		$this->template->setFile($this->options['template']);
		$this->template->setParameters($this->parameters);

		$this->template->add('_blueprint', $this->blueprint);
		$this->template->add('form', $form);

		return $this->template->renderToString();
	}

}
