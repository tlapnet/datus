<?php declare(strict_types = 1);

namespace Tests\Tlapnet\Datus\Unit\Schema\Layout;

use PHPUnit\Framework\TestCase;
use Tlapnet\Datus\Exception\Logical\InvalidStateException;
use Tlapnet\Datus\Schema\Layout\Group;
use Tlapnet\Datus\Schema\Layout\Input;
use Tlapnet\Datus\Schema\Layout\RichLayout;
use Tlapnet\Datus\Schema\Layout\Section;

class RichLayoutTest extends TestCase
{

	/** @var RichLayout */
	private $layout;

	protected function setUp(): void
	{
		$this->layout = new RichLayout();
	}

	public function testGetLayoutInputs(): void
	{
		$input1 = new Input('input1');
		$input2 = new Input('input2');

		$section1 = new Section('section1');
		$section1->setInputs([$input1, $input2]);

		$group1 = new Group('group1');
		$group1->setSections([$section1]);

		$input3 = new Input('input3');
		$input4 = new Input('input4');

		$section2 = new Section('section2');
		$section2->setInputs([$input3, $input4]);

		$group2 = new Group('group2');
		$group2->setSections([$section2]);

		$this->layout->setGroups([$group1, $group2]);

		$this->assertEquals([$input1, $input2, $input3, $input4], $this->layout->getLayoutInputs());
		// second call acts differently
		$this->assertEquals([$input1, $input2, $input3, $input4], $this->layout->getLayoutInputs());
	}

	public function testGetLayoutException(): void
	{
		$this->expectException(InvalidStateException::class);
		$this->expectExceptionMessage('No groups defined');
		$this->layout->getLayoutInputs();
	}

}
