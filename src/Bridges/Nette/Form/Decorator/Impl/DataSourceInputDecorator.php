<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Decorator\Impl;

use Nette\Forms\Controls\BaseControl;
use Nette\Forms\Controls\ChoiceControl;
use Tlapnet\Datus\Bridges\Nette\Form\Decorator\IInputDecorator;
use Tlapnet\Datus\Exception\Logical\InvalidStateException;
use Tlapnet\Datus\Form\DataSource\DataSourceContainer;
use Tlapnet\Datus\Form\DataSource\Impl\IDataSource;
use Tlapnet\Datus\Schema\FormInput;

final class DataSourceInputDecorator implements IInputDecorator
{

	/** @var DataSourceContainer */
	private $dataSources;

	public function __construct(DataSourceContainer $dataSources)
	{
		$this->dataSources = $dataSources;
	}

	public function apply(FormInput $input, BaseControl $control): void
	{
		$name = $input->getDecorator('dataSource');
		$dataSource = $this->dataSources->get($name);

		$this->applyDataSource($input, $control, $dataSource);
	}

	public function applyDataSource(FormInput $input, BaseControl $control, IDataSource $dataSource): void
	{
		if (!($control instanceof ChoiceControl)) {
			throw new InvalidStateException(sprintf('Only "%s" is supported', ChoiceControl::class));
		}

		$control->setItems($dataSource->getData());
	}

}
