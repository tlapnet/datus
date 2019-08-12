<?php declare(strict_types = 1);

namespace Tests\Tlapnet\Datus\Unit\Bridges\Symfony;

use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Contracts\Translation\TranslatorTrait;

class TestTranslator implements TranslatorInterface
{

	use TranslatorTrait;

}
