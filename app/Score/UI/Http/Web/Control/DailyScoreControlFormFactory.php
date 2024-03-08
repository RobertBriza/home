<?php

namespace app\Score\UI\Http\Web\Control;

use app\System\UI\Http\Web\Control\ControlFactory;

interface DailyScoreControlFormFactory extends ControlFactory
{
	public function create(\DateTimeImmutable $date): DailyScoreControlForm;
}