<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Schema\Layout;

use Tlapnet\Datus\Exception\Logical\InvalidStateException;
use Tlapnet\Datus\Schema\FormBlueprint;
use Tlapnet\Datus\Schema\FormInput;

class RichLayout extends Layout
{

	/** @var Group[] */
	protected $groups = [];

	/** @var Input[] */
	protected $inputs = [];

	/**
	 * @return Group[]
	 */
	public function getGroups(): array
	{
		return $this->groups;
	}

	/**
	 * @param Group[] $groups
	 */
	public function setGroups(array $groups): void
	{
		$this->groups = $groups;
	}

	/**
	 * @return FormInput[]
	 */
	public function getInputs(FormBlueprint $blueprint): array
	{
		return $blueprint->getInputs();
	}

	/**
	 * @return Input[]
	 */
	public function getLayoutInputs(): array
	{
		if ($this->inputs !== []) {
			return $this->inputs;
		}

		$groups = $this->getGroups();

		// Validate we have at least 1 group
		if ($groups === []) {
			throw new InvalidStateException('No groups defined');
		}

		foreach ($groups as $group) {
			foreach ($group->getSections() as $section) {
				$this->inputs = array_merge($this->inputs, $section->getInputs());
			}
		}

		return $this->inputs;
	}

}
