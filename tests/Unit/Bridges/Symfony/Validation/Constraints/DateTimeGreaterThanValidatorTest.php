<?php declare(strict_types = 1);

namespace Tests\Tlapnet\Datus\Unit\Bridges\Symfony\Validation\Constraints;

use PHPUnit\Framework\TestCase;
use Tests\Tlapnet\Datus\Unit\Bridges\Symfony\Validation\ValidationContextFactory;
use Tlapnet\Datus\Bridges\Symfony\Validation\Constraints\DateTimeGreaterThan;
use Tlapnet\Datus\Bridges\Symfony\Validation\Constraints\DateTimeGreaterThanValidator;

class DateTimeGreaterThanValidatorTest extends TestCase
{

	/**
	 * @param mixed $input
	 * @dataProvider validProvider
	 */
	public function testValidate($input): void
	{
		$constraint = new DateTimeGreaterThan();
		$context = ValidationContextFactory::create($constraint);

		$validator = new DateTimeGreaterThanValidator();
		$validator->initialize($context);
		$validator->validate($input, $constraint);

		$this->assertCount(0, $context->getViolations());
	}

	/**
	 * @param mixed $input
	 * @dataProvider invalidProvider
	 */
	public function testValidateInvalid($input): void
	{
		$constraint = new DateTimeGreaterThan();
		$context = ValidationContextFactory::create($constraint);

		$validator = new DateTimeGreaterThanValidator();
		$validator->initialize($context);
		$validator->validate($input, $constraint);

		$this->assertNotEmpty($context->getViolations()->__toString());
	}

	public function testValidatePast(): void
	{
		$constraint = new DateTimeGreaterThan();
		$context = ValidationContextFactory::create($constraint);

		$validator = new DateTimeGreaterThanValidator();
		$validator->initialize($context);
		$validator->validate('1.1.2019 10:00:00', $constraint);

		$this->assertStringMatchesFormat('%AThe "01.01.2019 10:00:00" must be greater then "%A".', trim($context->getViolations()->__toString()));
	}

	/**
	 * @return mixed[]
	 */
	public function validProvider(): iterable
	{
		yield ['+1 day'];
		yield ['next monday'];
		yield ['now + 1 minute'];
	}

	/**
	 * @return mixed[]
	 */
	public function invalidProvider(): iterable
	{
		yield ['foo'];
		yield ['foo2bar'];
		yield ['#'];
	}

}
