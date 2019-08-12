<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\DI\Pass;

use Contributte\DI\Helper\ExtensionDefinitionsHelper;
use Tlapnet\Datus\Form\DataSource\DataSourceContainer;

class DataSourcePass extends AbstractPass
{

	public function loadPassConfiguration(): void
	{
		$builder = $this->extension->getContainerBuilder();
		$config = $this->extension->getConfig()->dataSource;
		$compiler = $this->extension->getCompiler();
		$definitionsHelper = new ExtensionDefinitionsHelper($compiler);

		$dataSourceContainer = $builder->addDefinition($this->extension->prefix('dataSource.container'))
			->setFactory(DataSourceContainer::class);

		foreach ($config as $name => $dataSourceConfig) {
			$prefix = $this->extension->prefix('dataSource.' . $name . '.impl');
			$def = $definitionsHelper->getDefinitionFromConfig($dataSourceConfig, $prefix);

			$dataSourceContainer->addSetup('add', [$name, $def]);
		}
	}

}
