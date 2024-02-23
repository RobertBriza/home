<?php

declare(strict_types=1);

namespace App\System\Application\CQRS\Command;

abstract class UpdateCommand implements Command
{
	public int $id;
}
