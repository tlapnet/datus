<?php declare(strict_types = 1);

namespace Tests\Tlapnet\Datus\Unit\Schema;

use PHPUnit\Framework\TestCase;
use Tlapnet\Datus\Exception\Logical\InvalidStateException;
use Tlapnet\Datus\Schema\Input;

class InputTest extends TestCase
{

	/** @var Input */
	private $input;

	protected function setUp(): void
	{
		$this->input = new Input('foo');
	}

	public function testGetDecorator(): void
	{
		$decorator = 'bar';
		$this->input->setDecorators([
			'foo' => $decorator,
		]);
		$this->assertEquals($decorator, $this->input->getDecorator('foo'));
	}

	public function testGetDecoratorDefault(): void
	{
		$decorator = 'default';
		$this->assertEquals($decorator, $this->input->getDecorator('missing', $decorator));
	}

	public function testGetDecoratorException(): void
	{
		$this->expectException(InvalidStateException::class);
		$this->expectExceptionMessage('Decorator "missing" not found');
		$this->input->getDecorator('missing');
	}

	public function testGetOption(): void
	{
		$this->input->setOption('foo', 'bar');
		$this->assertEquals('bar', $this->input->getOption('foo'));
	}

	public function testGetOptionException(): void
	{
		$this->expectException(InvalidStateException::class);
		$this->expectExceptionMessage('Option "missing" not found');
		$this->input->getOption('missing');
	}

}
