<?php

declare(strict_types=1);

namespace app\System\Application\CQRS;

use app\System\Application\Provider\BusProvider;

abstract class BusAccess
{
	protected BusProvider $busProvider;

	public function setBusProvider(BusProvider $busProvider): void
	{
		$this->busProvider = $busProvider;
	}
}
