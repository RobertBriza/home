<?php

declare(strict_types=1);

namespace App\System\Application\CQRS\Command;

/** @property int $id */
abstract class DeleteCommand implements Command
{
	public int $id;
}
