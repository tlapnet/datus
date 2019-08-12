<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Schema\Layout;

use Tlapnet\Datus\Utils\TRender;

class Group
{

	use TRender;

	/** @var Section[] */
	protected $sections = [];

	/** @var string */
	protected $caption;

	/** @var string */
	private $id;

	public function __construct(string $id)
	{
		$this->id = $id;
	}

	public function getId(): string
	{
		return $this->id;
	}

	/**
	 * @return Section[]
	 */
	public function getSections(): array
	{
		return $this->sections;
	}

	/**
	 * @param Section[] $sections
	 */
	public function setSections(array $sections): void
	{
		$this->sections = $sections;
	}

	public function getCaption(): ?string
	{
		return $this->caption;
	}

	public function setCaption(string $caption): void
	{
		$this->caption = $caption;
	}

}
