<?php declare(strict_types = 1);

namespace Tests\Tlapnet\Datus\Unit\Schema\Layout;

use PHPUnit\Framework\TestCase;
use Tlapnet\Datus\Schema\Control;
use Tlapnet\Datus\Schema\FormBlueprint;
use Tlapnet\Datus\Schema\FormInput;
use Tlapnet\Datus\Schema\Layout\PositionLayout;

class PositionLayoutTest extends TestCase
{

	/** @var PositionLayout */
	private $layout;

	/** @var FormBlueprint */
	private $blueprint;

	protected function setUp(): void
	{
		$this->layout = new PositionLayout();
		$this->blueprint = new FormBlueprint('foo');
	}

	public function testGetInputs(): void
	{
		$input1 = new FormInput('foo');
		$input1->setControl(new Control('foo'));
		$this->blueprint->addInput($input1);

		$input2 = new FormInput('bar');
		$input2->setControl(new Control('foo'));
		$this->blueprint->addInput($input2);

		$this->assertEquals([$input1, $input2], $this->layout->getInputs($this->blueprint));
	}

	public function testGetInputsRepositioned(): void
	{
		$input1 = new FormInput('foo');
		$control1 = new Control('foo');
		$control1->setOption('position', 30);
		$input1->setControl($control1);
		$this->blueprint->addInput($input1);

		$input2 = new FormInput('bar');
		$control2 = new Control('bar');
		// position is counted dynamically
		$input2->setControl($control2);
		$this->blueprint->addInput($input2);

		$input3 = new FormInput('baz');
		$control3 = new Control('baz');
		$control3->setOption('position', 10);
		$input3->setControl($control3);
		$this->blueprint->addInput($input3);

		$this->assertEquals([$input3, $input2, $input1], $this->layout->getInputs($this->blueprint));
	}

}
