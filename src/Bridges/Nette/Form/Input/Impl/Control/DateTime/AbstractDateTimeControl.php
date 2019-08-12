<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Input\Impl\Control\DateTime;

use DateTimeImmutable;
use DateTimeInterface;
use Nette\Forms\Controls\TextBase;
use Nette\Forms\Form;
use Nette\Utils\Html;

abstract class AbstractDateTimeControl extends TextBase
{

	/** @var string */
	protected $controlType;

	/** @var string */
	protected $dateFormat;

	public function loadHttpData(): void
	{
		$this->setValue($this->getHttpData(Form::DATA_LINE));
	}

	public function getControl(): Html
	{
		$control = parent::getControl();

		$value = $this->getValue();

		if ($value !== null) {
			$control->value = $value->format($this->dateFormat);
		}

		return $control;
	}

	/**
	 * @param mixed $value
	 * @return static
	 */
	public function setValue($value)
	{
		return parent::setValue($value instanceof DateTimeInterface ? $value->format($this->dateFormat) : $value);
	}

	public function getValue(): ?DateTimeImmutable
	{
		if ($this->value === '' || $this->value === null) {
			return null;
		}

		if ($this->value instanceof DateTimeImmutable) {
			return $this->value;
		}

		// From timestamp
		if (ctype_digit((string) $this->value)) {
			$value = (new DateTimeImmutable())->setTimestamp((int) $this->value);

			if ($value !== false) {
				return $value;
			}

			$this->addError(sprintf('Value "%s" is not valid timestamp.', $this->value));
		}

		// From w3s official format
		if (is_string($this->value)) {
			$value = DateTimeImmutable::createFromFormat($this->dateFormat, $this->value);

			if ($value !== false) {
				return $value;
			}

			$this->addError(sprintf('Your browser doesn\'t support "%s" field. Provide date in "%s" format please.', $this->controlType, $this->dateFormat));
		}

		return null;
	}

}
