<?php declare(strict_types = 1);

namespace Tests\Tlapnet\Datus\Unit\Schema;

use PHPUnit\Framework\TestCase;
use Tlapnet\Datus\Exception\Logical\InvalidStateException;
use Tlapnet\Datus\Schema\Control;
use Tlapnet\Datus\Schema\FormInput;

class FormInputTest extends TestCase
{

	/** @var FormInput */
	private $input;

	protected function setUp(): void
	{
		parent::setUp();
		$this->input = new FormInput('foo');
	}

	public function testGetControl(): void
	{
		$control = new Control('foo');
		$this->input->setControl($control);
		$this->assertEquals($control, $this->input->getControl());
	}

	public function testGetControlException(): void
	{
		$this->expectException(InvalidStateException::class);
		$this->expectExceptionMessage('Control is not attached on input');
		$this->input->getControl();
	}

}
