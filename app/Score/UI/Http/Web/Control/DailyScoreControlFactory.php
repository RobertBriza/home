<?php

namespace app\Score\UI\Http\Web\Control;

use app\System\UI\Http\Web\Control\ControlFactory;

interface DailyScoreControlFactory extends ControlFactory
{
	public function create(): DailyScoreControl;
}