<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Utils;

use Tlapnet\Datus\Schema\FormInput;

class FormInputCorrector
{

	/** @var FormInput */
	protected $input;

	protected function __construct(FormInput $input)
	{
		$this->input = $input;
	}

	/**
	 * @param mixed[] $data
	 */
	public static function perform(FormInput $input, array $data): FormInput
	{
		$self = new self($input);

		if (isset($data['control'])) {
			$self->correctControl($data['control']);
		}

		if (isset($data['validations'])) {
			$self->correctValidations($data['validations']);
		}

		if (isset($data['filters'])) {
			$self->correctFilters($data['filters']);
		}

		if (isset($data['options'])) {
			$self->correctOptions($data['options']);
		}

		return $input;
	}

	/**
	 * @param mixed[] $data
	 */
	protected function correctControl(array $data): void
	{
		$control = $this->input->getControl();

		if (array_key_exists('label', $data)) {
			$control->setLabel($data['label']);
		}

		// Attributes are appended
		if (array_key_exists('attributes', $data)) {
			$control->addAttributes($data['attributes']);
		}

		// Options are appended
		if (array_key_exists('options', $data)) {
			$control->addOptions($data['options']);
		}
	}

	/**
	 * @param mixed[] $data
	 */
	protected function correctValidations(array $data): void
	{
		// Validations are replaced{
		$this->input->setValidations($data);
	}

	/**
	 * @param mixed[] $data
	 */
	protected function correctFilters(array $data): void
	{
		// Filters are replaced
		$this->input->setFilters($data);
	}

	/**
	 * @param mixed[] $data
	 */
	protected function correctOptions(array $data): void
	{
		// Options are appended
		$this->input->addOptions($data);
	}

}
