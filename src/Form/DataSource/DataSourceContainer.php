<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Form\DataSource;

use Tlapnet\Datus\Exception\Logical\InvalidStateException;
use Tlapnet\Datus\Form\DataSource\Impl\IDataSource;

class DataSourceContainer
{

	/** @var IDataSource[] */
	private $dataSources = [];

	public function add(string $name, IDataSource $dataSource): void
	{
		$this->dataSources[$name] = $dataSource;
	}

	public function get(string $name): IDataSource
	{
		if (!isset($this->dataSources[$name])) {
			throw new InvalidStateException(sprintf('Undefined data source "%s"', $name));
		}

		return $this->dataSources[$name];
	}

}
