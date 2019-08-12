<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\DI\Pass;

use Nette\PhpGenerator\ClassType;
use Tlapnet\Datus\Bridges\Nette\DI\DatusExtension;

abstract class AbstractPass
{

	/** @var DatusExtension */
	protected $extension;

	public function __construct(DatusExtension $extension)
	{
		$this->extension = $extension;
	}

	public function loadPassConfiguration(): void
	{
	}

	public function beforePassCompile(): void
	{
	}

	public function afterPassCompile(ClassType $class): void
	{
	}

}
