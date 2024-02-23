<?php

declare(strict_types=1);

namespace App\System\UI\Http\Web\Form;

use App\System\Application\Wiring\Autowired;
use Nette;

abstract class FormFactory implements Autowired
{
	use Nette\SmartObject;

	public function createForm(): BaseForm
	{
		return new BaseForm();
	}
}
