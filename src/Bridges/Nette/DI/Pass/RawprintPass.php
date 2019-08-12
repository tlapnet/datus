<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\DI\Pass;

use Nette\DI\Config\Adapters\NeonAdapter;
use Nette\DI\Definitions\ServiceDefinition;
use Nette\DI\Definitions\Statement;
use Nette\Schema\Expect;
use Nette\Schema\Schema;
use Nette\Utils\Finder;
use Tlapnet\Datus\Exception\Logical\InvalidStateException;
use Tlapnet\Datus\Schema\Rawprint;

class RawprintPass extends AbstractPass
{

	public static function getConfigSchema(): Schema
	{
		return Expect::structure([
			'file' => Expect::arrayOf('string'),
			'folder' => Expect::arrayOf('string'),
			'form' => Expect::arrayOf('array'),
		]);
	}

	public function loadPassConfiguration(): void
	{
		$config = $this->extension->getConfig()->rawprint;

		$this->registerRawprintsByFolders($config->folder);
		$this->registerRawprintsByFiles($config->file);
		$this->registerRawprintsByForms($config->form);
	}

	/**
	 * @param string[] $folders
	 */
	protected function registerRawprintsByFolders(array $folders): void
	{
		$files = [];

		foreach ($folders as $folder) {
			// Control check
			if (!is_dir($folder)) {
				throw new InvalidStateException(sprintf('Folder "%s" does not exist', $folder));
			}

			// Lookup for single files
			/** @var string $file */
			foreach (Finder::findFiles('*.neon')->from($folder) as $file) {
				// Append for bulk adding
				$files[] = $file;
			}
		}

		if ($files !== []) {
			$this->registerRawprintsByFiles($files);
		}
	}

	/**
	 * @param string[] $files
	 */
	protected function registerRawprintsByFiles(array $files): void
	{
		$loader = new NeonAdapter();
		$forms = [];

		foreach ($files as $file) {
			// Control check
			if (!file_exists($file)) {
				throw new InvalidStateException(sprintf('File "%s" does not exist', $file));
			}

			// Parse file content
			$rawprint = $loader->load($file);

			// Form name check
			if (count($rawprint) > 1) {
				throw new InvalidStateException(sprintf('Rawprint of "%s" must have only 1 root element. It\`s form name.', $file));
			}

			// Parse name and form definition
			$formName = key($rawprint);
			$form = $rawprint[$formName];

			// Append for bulk adding
			$forms[$formName] = $form;
		}

		if ($forms !== []) {
			$this->registerRawprintsByForms($forms);
		}
	}

	/**
	 * @param mixed[] $forms
	 */
	protected function registerRawprintsByForms(array $forms): void
	{
		$builder = $this->extension->getContainerBuilder();
		$formRegistry = $builder->getDefinition($this->extension->prefix('form.registry'));
		assert($formRegistry instanceof ServiceDefinition);

		foreach ($forms as $formName => $form) {
			$formRegistry->addSetup('add', [$formName, new Statement(Rawprint::class, [$form])]);
		}
	}

}
