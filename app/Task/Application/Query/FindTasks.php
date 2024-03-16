<?php

namespace app\Task\Application\Query;

final readonly class FindTasks
{
	public function __construct(public bool $onlyActive = true)
	{
	}
}