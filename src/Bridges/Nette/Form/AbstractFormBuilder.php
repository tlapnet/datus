<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form;

use Nette\Application\UI\Form;
use Nette\Forms\Container;
use Nette\Forms\Controls\BaseControl;
use Tlapnet\Datus\Bridges\Nette\Form\Input\InputBuilderContainer;
use Tlapnet\Datus\Exception\Logical\InvalidArgumentException;
use Tlapnet\Datus\Exception\Logical\InvalidStateException;
use Tlapnet\Datus\Form\FormData;
use Tlapnet\Datus\Form\IFormBuilder;
use Tlapnet\Datus\Schema\FormBlueprint;
use Tlapnet\Datus\Schema\FormInput;
use Tlapnet\Datus\Validation\IValidatorFactory;

abstract class AbstractFormBuilder implements IFormBuilder
{

	public const EVENT_FORM_AFTER_BUILD = 'form.build.before';
	public const EVENT_FORM_BEFORE_BUILD = 'form.build.after';
	public const EVENT_INPUT_BEFORE_BUILD = 'input.build.before';
	public const EVENT_INPUT_AFTER_BUILD = 'input.build.after';

	public const EVENTS = [
		self::EVENT_FORM_AFTER_BUILD,
		self::EVENT_FORM_BEFORE_BUILD,
		self::EVENT_INPUT_BEFORE_BUILD,
		self::EVENT_INPUT_AFTER_BUILD,
	];

	/** @var mixed[] */
	protected $triggers = [];

	/** @var InputBuilderContainer */
	protected $controlBuilders;

	/** @var IValidatorFactory */
	protected $validatorFactory;

	public function __construct(InputBuilderContainer $inputBuilderContainer, IValidatorFactory $validatorFactory)
	{
		$this->controlBuilders = $inputBuilderContainer;
		$this->validatorFactory = $validatorFactory;
	}

	public function addTrigger(string $event, object $trigger): void
	{
		if (!in_array($event, self::EVENTS, true)) {
			throw new InvalidArgumentException(sprintf('Unsupported event "%s"', $event));
		}

		if (!isset($this->triggers[$event])) {
			$this->triggers[$event] = [];
		}

		$this->triggers[$event][] = $trigger;
	}

	/**
	 * Builds Nette form by given blueprint
	 *
	 * @param mixed[] $args
	 * @return Form
	 */
	public function build(FormBlueprint $blueprint, array $args = []): object
	{
		// Create form (in child)
		$form = $this->createForm();

		// Trigger @FORM_BEFORE_BUILD
		$this->trigger(self::EVENT_FORM_BEFORE_BUILD, $blueprint, $form);

		// Create inputs
		$this->buildInputs($blueprint, $form);

		// Attach validations
		$this->buildValidations($blueprint, $form);

		// Trigger @FORM_AFTER_BUILD
		$this->trigger(self::EVENT_FORM_AFTER_BUILD, $blueprint, $form);

		return $form;
	}

	/**
	 * Creates new instance of Nette form
	 */
	abstract public function createForm(): Form;

	/**
	 * Creates and setup inputs to Nette form
	 */
	protected function buildInputs(FormBlueprint $blueprint, Form $form): void
	{
		$inputs = ($layout = $blueprint->getLayout()) !== null
			? $layout->getInputs($blueprint)
			: $blueprint->getInputs();

		$this->buildInputControls($inputs, $form);
	}

	/**
	 * @param FormInput[] $inputs
	 */
	protected function buildInputControls(array $inputs, Container $container): void
	{
		foreach ($inputs as $inputName => $input) {
			// Trigger @INPUT_BEFORE_BUILD
			$this->trigger(self::EVENT_INPUT_BEFORE_BUILD, $input);

			// Don't build input if it has disabled display
			if ($input->getOption('enabled', true) === false) {
				continue;
			}

			// Validate, that we have propel FormInput
			if (!($input instanceof FormInput)) {
				throw new InvalidStateException(sprintf('Input is not instance of "%s"', FormInput::class));
			}

			// Get input type and obtain propel builder
			$type = $input->getControl()->getType();

			// Validate, there exists propel builder
			if (!$this->controlBuilders->has($type)) {
				throw new InvalidStateException(sprintf('Cannot create control for type "%s"', $type));
			}

			// Create control of given type
			$control = $this->controlBuilders->get($type)->build($container, $input);

			// @nested create nested form container
			if ($type === FormInput::CONTAINER) {
				assert($control instanceof Container);
				$this->buildInputControls($input->getControl()->getOption('inputs'), $control);
			}

			// Trigger @INPUT_AFTER_BUILD
			$this->trigger(self::EVENT_INPUT_AFTER_BUILD, $input, $control);
		}
	}

	/**
	 * Creates and setup validators to Nette form
	 */
	protected function buildValidations(FormBlueprint $blueprint, Form $form): void
	{
		$form->onValidate[] = function (Form $form) use ($blueprint): void {
			// Create propel validator by blueprint
			$validator = $this->validatorFactory->create($blueprint);

			// Validate incoming request data
			$validationResult = $validator->validate(new FormData($blueprint, (array) $form->getValues()));

			// Add errors to form, if there any
			if (!$validationResult->isOk()) {
				// Add input-based errors
				foreach ($validationResult->getInputErrors() as $input => $errors) {
					foreach ($errors as $error) {
						/** @var BaseControl $control */
						$control = $form->getComponent($input);
						// Add error to input
						$control->addError($error);
					}
				}

				// Add form-based errors
				foreach ($validationResult->getErrors() as $error) {
					$form->addError($error);
				}
			}
		};
	}

	/**
	 * @param mixed ...$args
	 */
	protected function trigger(string $event, ...$args): void
	{
		// No registered triggers
		if (!isset($this->triggers[$event])) {
			return;
		}

		foreach ($this->triggers[$event] as $trigger) {
			call_user_func_array($trigger, $args);
		}
	}

}
