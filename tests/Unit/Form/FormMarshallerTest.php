<?php declare(strict_types = 1);

namespace Tests\Tlapnet\Datus\Unit\Form;

use PHPUnit\Framework\TestCase;
use Tlapnet\Datus\Form\FormMarshaller;
use Tlapnet\Datus\Schema\Blueprint;
use Tlapnet\Datus\Schema\Rawprint;

final class FormMarshallerTest extends TestCase
{

	/** @var FormMarshaller */
	private $marshaller;

	public function setUp(): void
	{
		parent::setUp();

		$this->marshaller = new FormMarshaller();
	}

	public function testMarshallDefaultMode(): void
	{
		$mode = 'default';
		$rawPrint = $this->createRawPrint();
		$bluePrint = $this->marshaller->marshall($rawPrint, $mode);

		$this->assertInstanceOf(Blueprint::class, $bluePrint);
		$this->assertEquals($mode, $bluePrint->getId());
		$this->assertCount(3, $bluePrint->getInputs());
		$this->assertEquals(['age', 'notes', 'send'], array_keys($bluePrint->getInputs()));
	}

	public function testMarshallExtendedMode(): void
	{
		$mode = 'edit';
		$rawPrint = $this->createRawPrint();
		$bluePrint = $this->marshaller->marshall($rawPrint, $mode);

		$this->assertInstanceOf(Blueprint::class, $bluePrint);
		$this->assertEquals($mode, $bluePrint->getId());
		$this->assertCount(3, $bluePrint->getInputs());
		$this->assertEquals(['notes', 'send', 'agree'], array_keys($bluePrint->getInputs()));
	}

	private function createRawPrint(): Rawprint
	{
		return new Rawprint([
			'modes' => [
				'default' => [
					'inputs' => [
						'age' => ['control' => ['type' => 'text', 'label' => 'Age']],
						'notes' => [
							'validations' => [
								'notBlank' => [],
								'regex' => ['pattern' => '#^[a-zA-Z]+$#', 'message' => 'Supported only a-zA-Z'],
							],
							'control' => [
								'label' => 'Notes',
								'type' => 'textarea',
								'decorators' => [],
								'attributes' => ['placeholder' => 'Fill me'],
							],
						],
						'send' => ['control' => ['type' => 'submit', 'label' => 'Save form']],
					],
				],
				'edit' => [
					'extends' => 'default',
					'inputs' => [
						'age' => false,
						'notes' => [
							'options' => ['advanced-control' => true],
							'control' => ['attributes' => ['placeholder' => 'Edit me']],
						],
						'agree' => ['control' => ['type' => 'checkbox', 'label' => 'Agree with consequences']],
						'send' => ['control' => ['label' => 'Update form']],
					],
				],
			],
		]);
	}

}
