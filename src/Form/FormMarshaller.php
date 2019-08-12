<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Form;

use Contributte\Utils\Merger;
use Nette\Utils\Strings;
use Tlapnet\Datus\Exception\Logical\InvalidArgumentException;
use Tlapnet\Datus\Exception\Logical\InvalidStateException;
use Tlapnet\Datus\Schema\Control;
use Tlapnet\Datus\Schema\FormBlueprint;
use Tlapnet\Datus\Schema\FormInput;
use Tlapnet\Datus\Schema\Input;
use Tlapnet\Datus\Schema\Layout\Group;
use Tlapnet\Datus\Schema\Layout\Input as LayoutInput;
use Tlapnet\Datus\Schema\Layout\Layout;
use Tlapnet\Datus\Schema\Layout\PositionLayout;
use Tlapnet\Datus\Schema\Layout\RichLayout;
use Tlapnet\Datus\Schema\Layout\Section;
use Tlapnet\Datus\Schema\Rawprint;

class FormMarshaller
{

	public function marshall(Rawprint $rawprint, string $mode = 'default'): FormBlueprint
	{
		// Validate mode exists
		if (!isset($rawprint['modes'][$mode])) {
			throw new InvalidArgumentException(sprintf('Cannot marshall undefined mode "%s"', $mode));
		}

		// Validate inputs exists
		if (!isset($rawprint['modes'][$mode]['inputs'])) {
			throw new InvalidArgumentException(sprintf('At least 1 input is required for mode "%s"', $mode));
		}

		// Merge definitions
		$mergedMode = $this->merge($rawprint, $mode);

		// Create blueprint
		$blueprint = new FormBlueprint($mode);
		$blueprint->addInputs($this->createInputs($mergedMode['inputs']));

		// Layout defined in mode overrides top-level layout
		if (isset($mergedMode['layout'])) {
			$blueprint->setLayout($this->createLayout($mergedMode['layout']));
		} else {
			$blueprint->setLayout($this->createLayout($rawprint['layout'] ?? null));
		}

		if (isset($rawprint['decorators'])) {
			$blueprint->setDecorators($rawprint['decorators']);
		}

		return $blueprint;
	}

	/**
	 * @return string[][]
	 */
	protected function merge(Rawprint $rawprint, string $mode): array
	{
		// Validate mode exists
		if (!isset($rawprint['modes'][$mode])) {
			throw new InvalidArgumentException(sprintf('Cannot merge undefined mode "%s"', $mode));
		}

		// Is mode extending?
		// - yes => merge with parent mode
		// - no => return mode
		if (isset($rawprint['modes'][$mode]['extends'])) {
			// @recursion
			$parent = $this->merge($rawprint, $rawprint['modes'][$mode]['extends']);

			return Merger::merge($rawprint['modes'][$mode], $parent);
		}

		return $rawprint['modes'][$mode];
	}

	/**
	 * @param mixed[] $inputs
	 * @return Input[]|FormInput[]
	 */
	protected function createInputs(array $inputs): array
	{
		$output = [];

		foreach ($inputs as $inputName => $input) {
			// Each input needs a name and name must be string
			if (!is_string($inputName) || strlen($inputName) <= 0) {
				throw new InvalidStateException(sprintf('Input name must be string, given "%s".', $inputName));
			}

			// Skip input (this could happen when some mode extends other mode and remove input)
			if ($input === false) {
				continue;
			}

			if (isset($input['control'])) {
				$output[$inputName] = $this->createFormInput($inputName, $input);
			} else {
				$output[$inputName] = $this->createInput($inputName, $input);
			}
		}

		return $output;
	}

	/**
	 * @param mixed[] $input
	 */
	protected function createInput(string $inputName, array $input): Input
	{
		$i = new Input($inputName);

		if (isset($input['description'])) {
			$i->setDescription($input['description']);
		}

		$i->setDefaultValue($input['defaultValue'] ?? null);
		$i->setFilters($input['filters'] ?? []);
		$i->setValidations($input['validations'] ?? []);
		$i->setConditions($input['conditions'] ?? []);
		$i->setOptions($input['options'] ?? []);
		$i->setDecorators($input['decorators'] ?? []);

		return $i;
	}

	/**
	 * @param mixed[] $input
	 */
	protected function createFormInput(string $inputName, array $input): FormInput
	{
		$i = new FormInput($inputName);

		if (isset($input['description'])) {
			$i->setDescription($input['description']);
		}

		$i->setDefaultValue($input['defaultValue'] ?? null);
		$i->setFilters($input['filters'] ?? []);
		$i->setValidations($input['validations'] ?? []);
		$i->setConditions($input['conditions'] ?? []);
		$i->setOptions($input['options'] ?? []);
		$i->setDecorators($input['decorators'] ?? []);

		$control = new Control($input['control']['type']);

		if (isset($input['control']['label'])) {
			$control->setLabel($input['control']['label']);
		}

		if (isset($input['control']['attributes'])) {
			$control->setAttributes($input['control']['attributes']);
		}

		if (isset($input['control']['options'])) {
			$control->setOptions($input['control']['options']);
		}

		$i->setControl($control);

		return $i;
	}

	/**
	 * @param mixed $layout
	 */
	protected function createLayout($layout): Layout
	{
		// Default layout
		if ($layout === null) {
			return new PositionLayout();
		}

		// String-based layout
		if (is_string($layout)) {
			if ($layout === 'positions') {
				return new PositionLayout();
			}

			throw new InvalidStateException(sprintf('Unknown static layout "%s"', $layout));
		}

		// Array-based a.k.a rich layout
		if (is_array($layout)) {
			return $this->createRichLayout($layout);
		}

		throw new InvalidStateException(sprintf('Unknown layout "%s"', $layout));
	}

	/**
	 * @param mixed[] $layout
	 */
	protected function createRichLayout(array $layout): RichLayout
	{
		// Validate groups exists
		if (!isset($layout['groups'])) {
			throw new InvalidArgumentException('Groups are required in layout');
		}

		$rl = new RichLayout();

		/**
		 * RichLayout
		 * ==========
		 * |- groups
		 *    |- sections
		 *       |- inputs
		 */

		// group ===========================================

		$groups = [];

		foreach ($layout['groups'] as $gid => $group) {
			// Skip group (this could happen when some mode extends other mode and remove layout group)
			if ($group === false) {
				continue;
			}

			// Group name must start with g*
			if (!Strings::startsWith($gid, 'g')) {
				throw new InvalidArgumentException(sprintf('Group ID must start with "g" given "%s"', $gid));
			}

			// Validate sections exists
			if (!isset($group['sections'])) {
				throw new InvalidArgumentException(sprintf('Section are required in group "%s"', $gid));
			}

			// Create new group
			$groups[(string) $gid] = $g = new Group((string) $gid);

			if (isset($group['caption'])) {
				$g->setCaption($group['caption']);
			}

			if (isset($group['render'])) {
				$g->setRenders($group['render']);
			}

			// group.sections ==============================

			$sections = [];

			foreach ($group['sections'] as $sid => $section) {
				// Skip section (this could happen when some mode extends other mode and remove layout section)
				if ($section === false) {
					continue;
				}

				// Section name must start with s*
				if (!Strings::startsWith($sid, 's')) {
					throw new InvalidArgumentException(sprintf('Section ID must start with "s" given "%s"', $sid));
				}

				// Validate inputs exists
				if (!isset($section['inputs'])) {
					throw new InvalidArgumentException(sprintf('Inputs are required in section "%s"', $sid));
				}

				// Create new section
				$sections[(string) $sid] = $s = new Section((string) $sid);

				if (isset($section['render'])) {
					$s->setRenders($section['render']);
				}

				// group.section.inputs ====================

				$inputs = [];

				foreach ($section['inputs'] as $iid => $input) {
					// Skip input (this could happen when some mode extends other mode and remove layout input)
					if ($input === false) {
						continue;
					}

					// Create new input
					$inputs[(string) $iid] = $i = new LayoutInput((string) $iid);

					// Set render options
					$i->setRenders($input);
				}

				// Inputs => section
				$s->setInputs($inputs);
			}

			// Sections => group
			$g->setSections($sections);
		}

		// Groups => layou
		$rl->setGroups($groups);

		return $rl;
	}

}
