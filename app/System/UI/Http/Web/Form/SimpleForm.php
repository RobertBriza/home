<?php

declare(strict_types=1);

namespace app\System\UI\Http\Web\Form;

use Exception;
use Nette\Forms\Controls\BaseControl;
use Nette\Forms\Form;

final class SimpleForm extends Form
{
	public function addErrorToControl(string $controlName, string $message): void
	{
		$control = $this[$controlName];

		if (($control instanceof BaseControl) === false) {
			throw new Exception('Component is not instance of BaseControl');
		}

		$control->addError($message);
	}
}
