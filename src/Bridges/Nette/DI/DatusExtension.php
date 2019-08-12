<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\DI;

use Nette\DI\Compiler;
use Nette\DI\CompilerExtension;
use Nette\DI\Definitions\Statement;
use Nette\PhpGenerator\ClassType;
use Nette\Schema\Expect;
use Nette\Schema\Schema;
use stdClass;
use Tlapnet\Datus\Bridges\Nette\DI\Pass\AbstractPass;
use Tlapnet\Datus\Bridges\Nette\DI\Pass\DataSourcePass;
use Tlapnet\Datus\Bridges\Nette\DI\Pass\FormPass;
use Tlapnet\Datus\Bridges\Nette\DI\Pass\RawprintPass;
use Tlapnet\Datus\Bridges\Nette\DI\Pass\ValidationPass;

/**
 * @property-read stdClass $config
 * @method stdClass getConfig()
 */
final class DatusExtension extends CompilerExtension
{

	public function getConfigSchema(): Schema
	{
		return Expect::structure([
			'dataSource' => Expect::arrayOf(
				Expect::anyOf(Expect::string(), Expect::array(), Expect::type(Statement::class))
			),
			'form' => FormPass::getConfigSchema(),
			'validation' => ValidationPass::getConfigSchema(),
			'rawprint' => RawprintPass::getConfigSchema(),
		]);
	}

	/** @var AbstractPass[] */
	private $passes = [];

	public function __construct()
	{
		$this->passes[] = new FormPass($this);
		$this->passes[] = new ValidationPass($this);
		$this->passes[] = new DataSourcePass($this);
		$this->passes[] = new RawprintPass($this);
	}

	public function loadConfiguration(): void
	{
		// Trigger passes
		foreach ($this->passes as $pass) {
			$pass->loadPassConfiguration();
		}
	}

	public function beforeCompile(): void
	{
		// Trigger passes
		foreach ($this->passes as $pass) {
			$pass->beforePassCompile();
		}
	}

	public function afterCompile(ClassType $class): void
	{
		// Trigger passes
		foreach ($this->passes as $pass) {
			$pass->afterPassCompile($class);
		}
	}

	public function getCompiler(): Compiler
	{
		return $this->compiler;
	}

}
