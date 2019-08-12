<?php declare(strict_types = 1);

namespace Tests\Tlapnet\Datus\Unit\Form\DataSource;

use PHPUnit\Framework\TestCase;
use Tlapnet\Datus\Exception\Logical\InvalidStateException;
use Tlapnet\Datus\Form\DataSource\DataSourceContainer;
use Tlapnet\Datus\Form\DataSource\Impl\ArrayDataSource;

class DataSourceContainerTest extends TestCase
{

	/** @var DataSourceContainer */
	private $container;

	protected function setUp(): void
	{
		$this->container = new DataSourceContainer();
	}

	public function testGet(): void
	{
		$dataSource = new ArrayDataSource(['foo', 'bar', 'baz']);
		$this->container->add('foo', $dataSource);
		$this->assertEquals($dataSource, $this->container->get('foo'));
	}

	public function testGetException(): void
	{
		$this->expectException(InvalidStateException::class);
		$this->expectExceptionMessage('Undefined data source "missing"');
		$this->container->get('missing');
	}

}
