<?php

declare(strict_types=1);

namespace App\System\Application\CQRS;

use App\System\Application\Provider\BusProvider;

abstract class BusAccess
{
	protected BusProvider $busProvider;

	public function setBusProvider(BusProvider $busProvider): void
	{
		$this->busProvider = $busProvider;
	}
}
