<?php

declare(strict_types=1);

namespace App\System\Application\CQRS;

final class Bus extends BusAccess
{
	public function sendCommand(object $command): void
	{
		$this->busProvider->sendCommand($command);
	}

	public function sendQuery(object $command): mixed
	{
		return $this->busProvider->sendQuery($command);
	}
}
