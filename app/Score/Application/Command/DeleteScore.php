<?php

declare(strict_types=1);

namespace app\Score\Application\Command;

use app\System\Application\CQRS\Command\DeleteCommand;

final class DeleteScore extends DeleteCommand
{
	public function __construct(public int $id)
	{
	}
}