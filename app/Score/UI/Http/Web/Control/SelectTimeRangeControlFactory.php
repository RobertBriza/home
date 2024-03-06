<?php

namespace app\Score\UI\Http\Web\Control;

use app\System\UI\Http\Web\Control\ControlFactory;

interface SelectTimeRangeControlFactory extends ControlFactory
{
	public function create(): SelectTimeRangeControl;
}