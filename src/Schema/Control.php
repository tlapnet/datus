<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Schema;

use Tlapnet\Datus\Utils\TAttributtes;
use Tlapnet\Datus\Utils\TOptions;

class Control
{

	use TOptions;
	use TAttributtes;

	public const CALLBACK_ON_CREATE = 'onCreate';

	/** @var ?string */
	protected $label;

	/** @var callable[][] */
	protected $callbacks = [
		'onCreate' => [],
	];

	/** @var string */
	private $type;

	public function __construct(string $type)
	{
		$this->type = $type;
	}

	public function getType(): string
	{
		return $this->type;
	}

	public function getLabel(): ?string
	{
		return $this->label;
	}

	public function setLabel(string $label): void
	{
		$this->label = $label;
	}

	public function addCallback(string $event, callable $callback): void
	{
		if (!isset($this->callbacks[$event])) {
			$this->callbacks[$event] = [];
		}

		$this->callbacks[$event][] = $callback;
	}

	/**
	 * @param mixed ...$args
	 */
	public function emit(string $event, ...$args): void
	{
		foreach ($this->callbacks[$event] as $callback) {
			call_user_func_array($callback, $args);
		}
	}

}
