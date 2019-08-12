<?php declare(strict_types = 1);

namespace Tests\Tlapnet\Datus\Unit\Schema;

use PHPUnit\Framework\TestCase;
use Tlapnet\Datus\Exception\Logical\InvalidArgumentException;
use Tlapnet\Datus\Exception\Logical\InvalidStateException;
use Tlapnet\Datus\Schema\FormBlueprint;
use Tlapnet\Datus\Schema\FormInput;
use Tlapnet\Datus\Schema\Input;

class FormBlueprintTest extends TestCase
{

	/** @var FormBlueprint */
	private $blueprint;

	protected function setUp(): void
	{
		$this->blueprint = new FormBlueprint('foo');
	}

	public function testAddInput(): void
	{
		$input = new FormInput('foo');
		$this->blueprint->addInput($input);
		$this->assertEquals($input, $this->blueprint->getInputs()['foo']);
	}

	public function testAddInputException(): void
	{
		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage(sprintf('Only "%s" are supported', FormInput::class));
		$input = new Input('foo');
		$this->blueprint->addInput($input);
	}

	public function testGetDecorator(): void
	{
		$decorator = 'bar';
		$this->blueprint->setDecorators([
			'foo' => $decorator,
		]);
		$this->assertEquals($decorator, $this->blueprint->getDecorator('foo'));
	}

	public function getDecoratorDefault(): void
	{
		$decorator = 'default';
		$this->assertEquals($decorator, $this->blueprint->getDecorator('missing', $decorator));
	}

	public function getDecoratorException(): void
	{
		$this->expectException(InvalidStateException::class);
		$this->expectExceptionMessage('Decorator "missing" not found');
		$this->blueprint->getDecorator('missing');
	}

}
