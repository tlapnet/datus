<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Form\DataSource\Impl;

class ArrayDataSource implements IDataSource
{

	/** @var mixed[] */
	private $items = [];

	/**
	 * @param mixed[] $items
	 */
	public function __construct(array $items)
	{
		$this->items = $items;
	}

	/**
	 * @return mixed
	 */
	public function getData()
	{
		return $this->items;
	}

}
