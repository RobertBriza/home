<?php

namespace app\Score\UI\Http\Web\Control;

use app\Score\Domain\Entity\Score;
use app\System\UI\Http\Web\Control\ControlFactory;
use DateTimeImmutable;

interface DailyScoreToggleControlFactory extends ControlFactory
{
	public function create(DateTimeImmutable $date, ?Score $score): DailyScoreToggleControl;
}