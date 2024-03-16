<?php

namespace app\Task\UI\Http\Web\Form;

use app\System\UI\Http\Web\Control\ControlFactory;

interface CreateTaskFormFactory extends ControlFactory
{
	public function create(): CreateTaskForm;
}