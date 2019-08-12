<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\DI\Pass;

use Nette\Schema\Expect;
use Nette\Schema\Schema;
use Tlapnet\Datus\Bridges\Symfony\Validation\Builder\Impl\BlankConstraintBuilder;
use Tlapnet\Datus\Bridges\Symfony\Validation\Builder\Impl\CurrencyConstraintBuilder;
use Tlapnet\Datus\Bridges\Symfony\Validation\Builder\Impl\DateConstraintBuilder;
use Tlapnet\Datus\Bridges\Symfony\Validation\Builder\Impl\DateTimeConstraintBuilder;
use Tlapnet\Datus\Bridges\Symfony\Validation\Builder\Impl\DateTimeGreaterThanConstraintBuilder;
use Tlapnet\Datus\Bridges\Symfony\Validation\Builder\Impl\EmailConstraintBuilder;
use Tlapnet\Datus\Bridges\Symfony\Validation\Builder\Impl\EqualToConstraintBuilder;
use Tlapnet\Datus\Bridges\Symfony\Validation\Builder\Impl\FileConstraintBuilder;
use Tlapnet\Datus\Bridges\Symfony\Validation\Builder\Impl\GreaterThanConstraintBuilder;
use Tlapnet\Datus\Bridges\Symfony\Validation\Builder\Impl\GreaterThanOrEqualConstraintBuilder;
use Tlapnet\Datus\Bridges\Symfony\Validation\Builder\Impl\IbanConstraintBuilder;
use Tlapnet\Datus\Bridges\Symfony\Validation\Builder\Impl\IdenticalToConstraintBuilder;
use Tlapnet\Datus\Bridges\Symfony\Validation\Builder\Impl\ImageConstraintBuilder;
use Tlapnet\Datus\Bridges\Symfony\Validation\Builder\Impl\IpConstraintBuilder;
use Tlapnet\Datus\Bridges\Symfony\Validation\Builder\Impl\IsbnConstraintBuilder;
use Tlapnet\Datus\Bridges\Symfony\Validation\Builder\Impl\LanguageConstraintBuilder;
use Tlapnet\Datus\Bridges\Symfony\Validation\Builder\Impl\LengthConstraintBuilder;
use Tlapnet\Datus\Bridges\Symfony\Validation\Builder\Impl\LessThanConstraintBuilder;
use Tlapnet\Datus\Bridges\Symfony\Validation\Builder\Impl\LessThanOrEqualConstraintBuilder;
use Tlapnet\Datus\Bridges\Symfony\Validation\Builder\Impl\LocaleConstraintBuilder;
use Tlapnet\Datus\Bridges\Symfony\Validation\Builder\Impl\NotBlankConstraintBuilder;
use Tlapnet\Datus\Bridges\Symfony\Validation\Builder\Impl\NotNullConstraintBuilder;
use Tlapnet\Datus\Bridges\Symfony\Validation\Builder\Impl\RangeConstraintBuilder;
use Tlapnet\Datus\Bridges\Symfony\Validation\Builder\Impl\RegexConstraintBuilder;
use Tlapnet\Datus\Bridges\Symfony\Validation\Builder\Impl\TimeConstraintBuilder;
use Tlapnet\Datus\Bridges\Symfony\Validation\Builder\Impl\UrlConstraintBuilder;
use Tlapnet\Datus\Bridges\Symfony\Validation\Builder\Impl\UuidConstraintBuilder;
use Tlapnet\Datus\Bridges\Symfony\Validation\ValidatorFactory;

class ValidationPass extends AbstractPass
{

	public static function getConfigSchema(): Schema
	{
		return Expect::structure([
			'constraintBuilder' => Expect::array(),
		]);
	}

	/** @var string[] */
	protected $constraintBuilders = [
		'blank' => BlankConstraintBuilder::class,
		'currency' => CurrencyConstraintBuilder::class,
		'date' => DateConstraintBuilder::class,
		'datetime' => DateTimeConstraintBuilder::class,
		'dateTimeGreaterThan' => DateTimeGreaterThanConstraintBuilder::class,
		'email' => EmailConstraintBuilder::class,
		'equalTo' => EqualToConstraintBuilder::class,
		'file' => FileConstraintBuilder::class,
		'greaterThan' => GreaterThanConstraintBuilder::class,
		'greaterThanOrEqual' => GreaterThanOrEqualConstraintBuilder::class,
		'iban' => IbanConstraintBuilder::class,
		'identicalTo' => IdenticalToConstraintBuilder::class,
		'image' => ImageConstraintBuilder::class,
		'ip' => IpConstraintBuilder::class,
		'isbn' => IsbnConstraintBuilder::class,
		'language' => LanguageConstraintBuilder::class,
		'length' => LengthConstraintBuilder::class,
		'lessThan' => LessThanConstraintBuilder::class,
		'lessThanOrEqual' => LessThanOrEqualConstraintBuilder::class,
		'locale' => LocaleConstraintBuilder::class,
		'notBlank' => NotBlankConstraintBuilder::class,
		'notNull' => NotNullConstraintBuilder::class,
		'range' => RangeConstraintBuilder::class,
		'regex' => RegexConstraintBuilder::class,
		'time' => TimeConstraintBuilder::class,
		'url' => UrlConstraintBuilder::class,
		'uuid' => UuidConstraintBuilder::class,
	];

	public function loadPassConfiguration(): void
	{
		$builder = $this->extension->getContainerBuilder();
		$config = $this->extension->getConfig()->validation;

		$validatorFactory = $builder->addDefinition($this->extension->prefix('validation.validator.factory'))
			->setFactory(ValidatorFactory::class);

		// Add all constrains to validator factory
		$constraintBuilders = array_merge($this->constraintBuilders, $config->constraintBuilder);

		foreach ($constraintBuilders as $name => $constraintBuilder) {
			// Don't register builder, if it's disabled
			if ($constraintBuilder === null) {
				continue;
			}

			$def = $builder->addDefinition($this->extension->prefix('validation.constraint.' . $name . '.builder'))
				->setFactory($constraintBuilder)
				->setAutowired(false);

			$validatorFactory->addSetup('addBuilder', [$name, $def]);
		}
	}

}
