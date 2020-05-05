<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Validation;

class ValidationResult
{

	/** @var string[] */
	private $errors = [];

	/** @var string[][] */
	private $inputErrors = [];

	public function isOk(): bool
	{
		return $this->errors === [] && $this->inputErrors === [];
	}

	public function addError(string $error): void
	{
		$this->errors[] = $error;
	}

	/**
	 * @param string[] $errors
	 */
	public function addErrors(array $errors): void
	{
		foreach ($errors as $error) {
			$this->addError($error);
		}
	}

	/**
	 * @return string[]
	 */
	public function getErrors(): array
	{
		return $this->errors;
	}

	public function addInputError(string $input, string $error): void
	{
		$this->inputErrors[$input][] = $error;
	}

	/**
	 * @param mixed[] $errors
	 */
	public function addInputErrors(array $errors): void
	{
		foreach ($errors as $input => $error) {
			$this->addInputError($input, $error);
		}
	}

	/**
	 * @return string[][]
	 */
	public function getInputErrors(): array
	{
		return $this->inputErrors;
	}

	public static function of(): self
	{
		return new self();
	}

}
