<?php declare(strict_types = 1);

namespace Tests\Tlapnet\Datus\Unit\Schema;

use PHPUnit\Framework\TestCase;
use Tlapnet\Datus\Exception\Logical\InvalidArgumentException;
use Tlapnet\Datus\Schema\Rawprint;

class RawprintTest extends TestCase
{

	/** @var Rawprint */
	private $rawprint;

	protected function setUp(): void
	{
		$this->rawprint = new Rawprint();
	}

	public function testOffsetGet(): void
	{
		$this->rawprint->offsetSet('foo', 'bar');
		$this->assertEquals('bar', $this->rawprint->offsetGet('foo'));
	}

	public function testOffsetGetException(): void
	{
		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('Key "missing" does not exist');
		$this->rawprint->offsetGet('missing');
	}

}
