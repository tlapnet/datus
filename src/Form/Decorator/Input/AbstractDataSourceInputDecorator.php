<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Form\Decorator\Input;

use Tlapnet\Datus\Form\DataSource\DataSourceContainer;
use Tlapnet\Datus\Form\DataSource\Impl\IDataSource;
use Tlapnet\Datus\Schema\FormInput;

abstract class AbstractDataSourceInputDecorator extends AbstractFormInputDecorator
{

	/** @var DataSourceContainer */
	private $dataSources;

	public function __construct(DataSourceContainer $dataSources)
	{
		$this->dataSources = $dataSources;
	}

	public function applyInput(FormInput $input): void
	{
		$name = $input->getDecorator('dataSource');
		$dataSource = $this->dataSources->get($name);

		$this->applyInputDataSource($input, $dataSource);
	}

	abstract public function applyInputDataSource(FormInput $input, IDataSource $dataSource): void;

}
