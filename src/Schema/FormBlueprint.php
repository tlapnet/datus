<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Schema;

use Tlapnet\Datus\Exception\Logical\InvalidArgumentException;
use Tlapnet\Datus\Schema\Layout\Layout;
use Tlapnet\Datus\Utils\TDecorators;

/**
 * @method FormInput[] addInputs(array $inputs)
 * @method FormInput[] getInputs()
 * @method FormInput getInput(string $id)
 */
class FormBlueprint extends Blueprint
{

	use TDecorators;

	/** @var ?Layout */
	protected $layout;

	/** @var mixed[] */
	protected $decorators = [];

	public function addInput(Input $input): void
	{
		if (!($input instanceof FormInput)) {
			throw new InvalidArgumentException(sprintf('Only "%s" are supported', FormInput::class));
		}

		parent::addInput($input);
	}

	public function getLayout(): ?Layout
	{
		return $this->layout;
	}

	public function setLayout(Layout $layout): void
	{
		$this->layout = $layout;
	}

}
