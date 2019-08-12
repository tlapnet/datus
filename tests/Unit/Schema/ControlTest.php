<?php declare(strict_types = 1);

namespace Tests\Tlapnet\Datus\Unit\Schema;

use PHPUnit\Framework\TestCase;
use Tlapnet\Datus\Exception\Logical\InvalidStateException;
use Tlapnet\Datus\Schema\Control;

class ControlTest extends TestCase
{

	/** @var Control */
	private $control;

	protected function setUp(): void
	{
		$this->control = new Control('foo');
	}

	public function testGetOption(): void
	{
		$this->control->setOption('foo', 'bar');
		$this->assertEquals('bar', $this->control->getOption('foo'));
	}

	public function testGetOptionException(): void
	{
		$this->expectException(InvalidStateException::class);
		$this->expectExceptionMessage('Option "missing" not found');
		$this->control->getOption('missing');
	}

	public function testGetOptionDefault(): void
	{
		$this->assertEquals('default', $this->control->getOption('missing', 'default'));
	}

	public function testEmit(): void
	{
		$this->expectOutputString('foo');

		$this->control->addCallback($this->control::CALLBACK_ON_CREATE, function (string $output): void {
			echo $output;
		});

		$this->control->emit($this->control::CALLBACK_ON_CREATE, 'foo');
	}

}
