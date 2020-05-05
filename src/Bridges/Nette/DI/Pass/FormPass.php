<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\DI\Pass;

use Contributte\DI\Helper\ExtensionDefinitionsHelper;
use Nette\DI\Definitions\ServiceDefinition;
use Nette\DI\Definitions\Statement;
use Nette\Schema\Expect;
use Nette\Schema\Schema;
use Tlapnet\Datus\Bridges\Nette\Form\Decorator\FormDecoratorContainer;
use Tlapnet\Datus\Bridges\Nette\Form\Decorator\FormDecoratorManager;
use Tlapnet\Datus\Bridges\Nette\Form\Decorator\InputDecoratorContainer;
use Tlapnet\Datus\Bridges\Nette\Form\Decorator\InputDecoratorManager;
use Tlapnet\Datus\Bridges\Nette\Form\Filter\FilterBuilderContainer;
use Tlapnet\Datus\Bridges\Nette\Form\Filter\Impl\LowercaseFilterBuilder;
use Tlapnet\Datus\Bridges\Nette\Form\FormCreator;
use Tlapnet\Datus\Bridges\Nette\Form\FormRegistry;
use Tlapnet\Datus\Bridges\Nette\Form\Input\Impl\ButtonControlBuilder;
use Tlapnet\Datus\Bridges\Nette\Form\Input\Impl\CheckboxControlBuilder;
use Tlapnet\Datus\Bridges\Nette\Form\Input\Impl\CheckboxListControlBuilder;
use Tlapnet\Datus\Bridges\Nette\Form\Input\Impl\DateControlBuilder;
use Tlapnet\Datus\Bridges\Nette\Form\Input\Impl\DateTimeLocalControlBuilder;
use Tlapnet\Datus\Bridges\Nette\Form\Input\Impl\EmailControlBuilder;
use Tlapnet\Datus\Bridges\Nette\Form\Input\Impl\HiddenControlBuilder;
use Tlapnet\Datus\Bridges\Nette\Form\Input\Impl\IControlBuilder;
use Tlapnet\Datus\Bridges\Nette\Form\Input\Impl\ImageControlBuilder;
use Tlapnet\Datus\Bridges\Nette\Form\Input\Impl\IntegerControlBuilder;
use Tlapnet\Datus\Bridges\Nette\Form\Input\Impl\MultiSelectControlBuilder;
use Tlapnet\Datus\Bridges\Nette\Form\Input\Impl\MultiUploadControlBuilder;
use Tlapnet\Datus\Bridges\Nette\Form\Input\Impl\PasswordControlBuilder;
use Tlapnet\Datus\Bridges\Nette\Form\Input\Impl\RadioListControlBuilder;
use Tlapnet\Datus\Bridges\Nette\Form\Input\Impl\SelectControlBuilder;
use Tlapnet\Datus\Bridges\Nette\Form\Input\Impl\SubmitControlBuilder;
use Tlapnet\Datus\Bridges\Nette\Form\Input\Impl\TextAreaControlBuilder;
use Tlapnet\Datus\Bridges\Nette\Form\Input\Impl\TextControlBuilder;
use Tlapnet\Datus\Bridges\Nette\Form\Input\Impl\TimeControlBuilder;
use Tlapnet\Datus\Bridges\Nette\Form\Input\Impl\UploadControlBuilder;
use Tlapnet\Datus\Bridges\Nette\Form\Input\InputBuilderContainer;
use Tlapnet\Datus\Bridges\Nette\Form\SimpleFormBuilder;

class FormPass extends AbstractPass
{

	public static function getConfigSchema(): Schema
	{
		return Expect::structure([
			'controlBuilder' => Expect::array(),
			'filterBuilder' => Expect::array(),
			'decorator' => Expect::arrayOf(
				Expect::anyOf(Expect::string(), Expect::array(), Expect::type(Statement::class))
			),
			'inputDecorator' => Expect::arrayOf(
				Expect::anyOf(Expect::string(), Expect::array(), Expect::type(Statement::class))
			),
			'trigger' => Expect::arrayOf(
				Expect::anyOf(Expect::string(), Expect::array(), Expect::type(Statement::class))
			),
		]);
	}

	/** @var string[]|IControlBuilder[] */
	protected $controlBuilders = [
		'button' => ButtonControlBuilder::class,
		'checkbox' => CheckboxControlBuilder::class,
		'checkboxlist' => CheckboxListControlBuilder::class,
		'date' => DateControlBuilder::class,
		'datetime' => DateTimeLocalControlBuilder::class,
		'email' => EmailControlBuilder::class,
		'hidden' => HiddenControlBuilder::class,
		'image' => ImageControlBuilder::class,
		'integer' => IntegerControlBuilder::class,
		'multiselect' => MultiSelectControlBuilder::class,
		'multiupload' => MultiUploadControlBuilder::class,
		'password' => PasswordControlBuilder::class,
		'radiolist' => RadioListControlBuilder::class,
		'select' => SelectControlBuilder::class,
		'submit' => SubmitControlBuilder::class,
		'textarea' => TextAreaControlBuilder::class,
		'text' => TextControlBuilder::class,
		'time' => TimeControlBuilder::class,
		'upload' => UploadControlBuilder::class,
	];

	/** @var string[] */
	protected $filterBuilders = [
		'lowercase' => LowercaseFilterBuilder::class,
	];

	public function loadPassConfiguration(): void
	{
		$builder = $this->extension->getContainerBuilder();

		$builder->addDefinition($this->extension->prefix('form.registry'))
			->setFactory(FormRegistry::class);

		$builder->addDefinition($this->extension->prefix('form.creator'))
			->setFactory(FormCreator::class);

		$builder->addDefinition($this->extension->prefix('form.builder'))
			->setFactory(SimpleFormBuilder::class);

		$this->loadControlBuildersConfiguration();
		$this->loadFilterBuildersConfiguration();
		$this->loadDecoratorConfiguration();
		$this->loadInputDecoratorConfiguration();
		$this->loadTriggerConfiguration();
	}

	public function loadControlBuildersConfiguration(): void
	{
		$builder = $this->extension->getContainerBuilder();
		$config = $this->extension->getConfig()->form;

		$inputContainer = $builder->addDefinition($this->extension->prefix('form.input.container'))
			->setFactory(InputBuilderContainer::class);

		// Add all controls builders to form builder
		$controlBuilders = array_merge($this->controlBuilders, $config->controlBuilder);

		foreach ($controlBuilders as $name => $controlBuilder) {
			// Don't register builder, if it's disabled
			if ($controlBuilder === null) {
				continue;
			}

			$def = $builder->addDefinition($this->extension->prefix('form.input.control.' . $name . '.builder'))
				->setFactory($controlBuilder)
				->setAutowired(false);

			$inputContainer->addSetup('add', [$name, $def]);
		}
	}

	public function loadFilterBuildersConfiguration(): void
	{
		$builder = $this->extension->getContainerBuilder();
		$config = $this->extension->getConfig()->form;

		$filterContainer = $builder->addDefinition($this->extension->prefix('form.filter.container'))
			->setFactory(FilterBuilderContainer::class);

		// Add all filters builders to form builder
		$filterBuilders = array_merge($this->filterBuilders, $config->filterBuilder);

		foreach ($filterBuilders as $name => $filterBuilder) {
			// Don't register builder, if it's disabled
			if ($filterBuilder === null) {
				continue;
			}

			$def = $builder->addDefinition($this->extension->prefix('form.filter.' . $name . '.builder'))
				->setFactory($filterBuilder)
				->setAutowired(false);

			$filterContainer->addSetup('add', [$name, $def]);
		}
	}

	protected function loadDecoratorConfiguration(): void
	{
		$builder = $this->extension->getContainerBuilder();
		$config = $this->extension->getConfig()->form;
		$compiler = $this->extension->getCompiler();
		$definitionsHelper = new ExtensionDefinitionsHelper($compiler);

		$builder->addDefinition($this->extension->prefix('form.decorator.form.manager'))
			->setFactory(FormDecoratorManager::class);

		$formDecoratorContainer = $builder->addDefinition($this->extension->prefix('form.decorator.form.container'))
			->setFactory(FormDecoratorContainer::class);

		foreach ($config->decorator as $name => $decoratorConfig) {
			$prefix = $this->extension->prefix('form.decorator.' . $name . '.impl');
			$def = $definitionsHelper->getDefinitionFromConfig($decoratorConfig, $prefix);

			$formDecoratorContainer->addSetup('add', [$name, $def]);
		}
	}

	protected function loadInputDecoratorConfiguration(): void
	{
		$builder = $this->extension->getContainerBuilder();
		$config = $this->extension->getConfig()->form;
		$compiler = $this->extension->getCompiler();
		$definitionsHelper = new ExtensionDefinitionsHelper($compiler);

		$builder->addDefinition($this->extension->prefix('form.decorator.input.manager'))
			->setFactory(InputDecoratorManager::class);

		$inputDecoratorContainer = $builder->addDefinition($this->extension->prefix('form.decorator.input.container'))
			->setFactory(InputDecoratorContainer::class);

		foreach ($config->inputDecorator as $name => $decoratorConfig) {
			$prefix = $this->extension->prefix('form.decorator.input.' . $name . '.impl');
			$def = $definitionsHelper->getDefinitionFromConfig($decoratorConfig, $prefix);

			$inputDecoratorContainer->addSetup('add', [$name, $def]);
		}
	}

	protected function loadTriggerConfiguration(): void
	{
		$builder = $this->extension->getContainerBuilder();
		$config = $this->extension->getConfig()->form;
		$compiler = $this->extension->getCompiler();
		$definitionsHelper = new ExtensionDefinitionsHelper($compiler);

		$formBuilder = $builder->getDefinition($this->extension->prefix('form.builder'));
		assert($formBuilder instanceof ServiceDefinition);

		foreach ($config->trigger as $event => $triggers) {
			foreach ($triggers as $name => $triggerConfig) {
				$prefix = $this->extension->prefix('form.trigger.' . str_replace('.', '_', $event) . '.' . $name);
				$def = $definitionsHelper->getDefinitionFromConfig($triggerConfig, $prefix);

				$formBuilder->addSetup('addTrigger', [$event, $def]);
			}
		}
	}

}
