<?php declare(strict_types = 1);

namespace Tests\Tlapnet\Datus\Unit\Form\Decorator;

use PHPUnit\Framework\TestCase;
use Tlapnet\Datus\Exception\Logical\InvalidStateException;
use Tlapnet\Datus\Form\Decorator\Input\IInputDecorator;
use Tlapnet\Datus\Form\Decorator\InputDecoratorContainer;
use Tlapnet\Datus\Schema\Input;

class InputDecoratorContainerTest extends TestCase
{

	/** @var InputDecoratorContainer */
	private $container;

	protected function setUp(): void
	{
		$this->container = new InputDecoratorContainer();
	}

	public function testGet(): void
	{
		$decorator = new class implements IInputDecorator
		{

			public function apply(Input $input): void
			{
			}

		};

		$this->container->add('foo', $decorator);
		$this->assertEquals($decorator, $this->container->get('foo'));
	}

	public function testGetException(): void
	{
		$this->expectException(InvalidStateException::class);
		$this->expectExceptionMessage('Undefined decorator "missing"');
		$this->container->get('missing');
	}

}
