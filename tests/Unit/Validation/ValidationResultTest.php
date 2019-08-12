<?php declare(strict_types = 1);

namespace Tests\Tlapnet\Datus\Unit\Validation;

use PHPUnit\Framework\TestCase;
use Tlapnet\Datus\Validation\ValidationResult;

class ValidationResultTest extends TestCase
{

	/** @var ValidationResult */
	private $validationResult;

	protected function setUp(): void
	{
		$this->validationResult = new ValidationResult();
	}

	public function testIsOkTrue(): void
	{
		$this->assertTrue($this->validationResult->isOk());
	}

	public function testIsOkFalse(): void
	{
		$this->validationResult->addError('foo');
		$this->assertFalse($this->validationResult->isOk());
	}

}
