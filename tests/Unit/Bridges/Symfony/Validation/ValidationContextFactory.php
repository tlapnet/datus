<?php declare(strict_types = 1);

namespace Tests\Tlapnet\Datus\Unit\Bridges\Symfony\Validation;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Context\ExecutionContextFactory;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Validation;
use Tests\Tlapnet\Datus\Unit\Bridges\Symfony\TestTranslator;

final class ValidationContextFactory
{

	public static function create(Constraint $constraint): ExecutionContextInterface
	{
		$contextFactory = new ExecutionContextFactory(new TestTranslator());
		$context = $contextFactory->createContext(Validation::createValidator(), null);
		$context->setConstraint($constraint);

		return $context;
	}

}
