<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Validation;

class ValidationResultBuilder
{

	/** @var ValidationResult */
	private $result;

	private function __construct()
	{
		$this->result = new ValidationResult();
	}

	public function addError(string $error): self
	{
		$this->result->addError($error);

		return $this;
	}

	/**
	 * @param string[] $errors
	 */
	public function addErrors(array $errors): self
	{
		$this->result->addErrors($errors);

		return $this;
	}

	public function addInputError(string $input, string $error): self
	{
		$this->result->addInputError($input, $error);

		return $this;
	}

	/**
	 * @param string[] $errors
	 */
	public function addInputErrors(array $errors): self
	{
		$this->result->addInputErrors($errors);

		return $this;
	}

	public function build(): ValidationResult
	{
		return $this->result;
	}

	public static function of(): self
	{
		return new static();
	}

}
