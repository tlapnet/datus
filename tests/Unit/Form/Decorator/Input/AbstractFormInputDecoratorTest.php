<?php declare(strict_types = 1);

namespace Tests\Tlapnet\Datus\Unit\Form\Decorator\Input;

use PHPUnit\Framework\TestCase;
use Tlapnet\Datus\Exception\Logical\InvalidStateException;
use Tlapnet\Datus\Form\Decorator\Input\AbstractFormInputDecorator;
use Tlapnet\Datus\Schema\FormInput;
use Tlapnet\Datus\Schema\Input;

class AbstractFormInputDecoratorTest extends TestCase
{

	/** @var AbstractFormInputDecorator */
	private $decorator;

	protected function setUp(): void
	{
		$this->decorator = new class extends AbstractFormInputDecorator
		{

			public function applyInput(FormInput $input): void
			{
				echo 'applied';
			}

		};
	}

	public function testApply(): void
	{
		$this->expectOutputString('applied');
		$this->decorator->apply(new FormInput('foo'));
	}

	public function testApplyException(): void
	{
		$this->expectException(InvalidStateException::class);
		$this->expectExceptionMessage(sprintf('Only input of type "%s" is supported', FormInput::class));
		$this->decorator->apply(new Input('foo'));
	}

}
