<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form;

use Nette\Application\UI\Form;
use Tlapnet\Datus\Form\FormMarshaller;
use Tlapnet\Datus\Form\IFormBuilder;
use Tlapnet\Datus\Schema\FormBlueprint;
use Tlapnet\Datus\Schema\Rawprint;

class FormCreator
{

	/** @var IFormBuilder */
	protected $formBuilder;

	/** @var FormRegistry */
	protected $formRegistry;

	/** @var FormMarshaller|NULL */
	protected $formMarshaller;

	public function __construct(IFormBuilder $formBuilder, FormRegistry $formRegistry)
	{
		$this->formBuilder = $formBuilder;
		$this->formRegistry = $formRegistry;
	}

	/**
	 * Lookup for rawprint in registry.
	 */
	public function get(string $name): Rawprint
	{
		return $this->formRegistry->get($name);
	}

	/**
	 * Creates Nette form.
	 *
	 * @param mixed[] $args
	 */
	public function create(string $name, array $args = []): Form
	{
		// Fetch rawprint by unique name
		$rawprint = $this->get($name);

		// Detect render mode
		$mode = $args['mode'] ?? 'default';

		// Convert rawprint into blueprint
		// @todo caching
		$blueprint = $this->getMarshaller()->marshall($rawprint, $mode);

		// Provide options for blueprint
		if (isset($args['props'])) {
			$blueprint->setOption('props', $args['props']);
		}

		// Build Nette form by blueprint
		$netteForm = $this->build($blueprint, $args);

		return $netteForm;
	}

	/**
	 * Creates Nette form by given raw schema
	 *
	 * @param mixed[] $raw
	 * @param mixed[] $args
	 */
	public function createWith(array $raw, array $args = []): Form
	{
		// Detect render mode
		$mode = $args['mode'] ?? 'default';

		// Convert rawprint into blueprint
		// @todo caching
		$blueprint = $this->getMarshaller()->marshall(new Rawprint($raw), $mode);

		// Provide options for blueprint
		if (isset($args['props'])) {
			$blueprint->setOption('props', $args['props']);
		}

		// Build Nette form by blueprint
		$netteForm = $this->build($blueprint, $args);

		return $netteForm;
	}

	/**
	 * Creates Nette form from Form Blueprint.
	 *
	 * @param mixed[] $args
	 */
	public function build(FormBlueprint $blueprint, array $args = []): Form
	{
		/** @var Form $form */
		$form = $this->formBuilder->build($blueprint, $args);

		return $form;
	}

	/**
	 * Creates Form builder
	 */
	public function builder(string $name): FormCreatorBuilder
	{
		return (new FormCreatorBuilder($this))->of($name);
	}

	/**
	 * Creates FormMarshaller only once and lazy
	 */
	protected function getMarshaller(): FormMarshaller
	{
		if ($this->formMarshaller === null) {
			$this->formMarshaller = new FormMarshaller();
		}

		return $this->formMarshaller;
	}

}
