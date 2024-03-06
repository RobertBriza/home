<?php

namespace app\Score\UI\Http\Web\Control;

use app\Score\UI\Http\Web\ScorePresenter;
use app\System\UI\Http\Web\Control\BaseControl;

/** @property ScorePresenter $presenter */
class SelectTimeRangeControl extends BaseControl
{
	public function render(mixed ...$args): void
	{
		$this->template->range = $args['range'] ?? null;
		$this->template->dto = $args['dayDTO'];

		parent::render($args);
	}
}