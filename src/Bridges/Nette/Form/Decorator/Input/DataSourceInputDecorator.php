<?php declare(strict_types = 1);

namespace Tlapnet\Datus\Bridges\Nette\Form\Decorator\Input;

use Nette\Forms\Controls\BaseControl;
use Nette\Forms\Controls\ChoiceControl;
use Tlapnet\Datus\Exception\Logical\InvalidStateException;
use Tlapnet\Datus\Form\DataSource\Impl\IDataSource;
use Tlapnet\Datus\Form\Decorator\Input\AbstractDataSourceInputDecorator;
use Tlapnet\Datus\Schema\Control;
use Tlapnet\Datus\Schema\FormInput;

final class DataSourceInputDecorator extends AbstractDataSourceInputDecorator
{

	public function applyInputDataSource(FormInput $input, IDataSource $dataSource): void
	{
		$input->getControl()->addCallback(Control::CALLBACK_ON_CREATE, function (BaseControl $control) use ($dataSource): void {
			if (!($control instanceof ChoiceControl)) {
				throw new InvalidStateException(sprintf('Only "%s" is supported', ChoiceControl::class));
			}

			$control->setItems($dataSource->getData());
		});
	}

}
