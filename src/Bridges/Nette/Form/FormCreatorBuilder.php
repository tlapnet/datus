<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form;

use Nette\Application\UI\Form;
use Tlapnet\Datus\Exception\Logical\InvalidStateException;

class FormCreatorBuilder
{

	/** @var FormCreator */
	protected $formCreator;

	/** @var mixed[] */
	protected $args = [];

	/** @var string|null */
	protected $name;

	public function __construct(FormCreator $formCreator)
	{
		$this->formCreator = $formCreator;
	}

	public function of(string $name): self
	{
		$this->name = $name;

		return $this;
	}

	public function withMode(string $mode): self
	{
		$this->args['mode'] = $mode;

		return $this;
	}

	/**
	 * @param mixed[] $args
	 */
	public function withArgs(array $args): self
	{
		$this->args = $args;

		return $this;
	}

	/**
	 * @param mixed[] $props
	 */
	public function withProps(array $props): self
	{
		$this->args['props'] = $props;

		return $this;
	}

	public function create(): Form
	{
		if ($this->name === null) {
			throw new InvalidStateException('Form name is required');
		}

		return $this->formCreator->create($this->name, $this->args);
	}

}
