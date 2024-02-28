<?php

namespace app\System\UI\Http\Web\Template;

use AllowDynamicProperties;
use app\Day\Domain\DayInfoDTO;
use app\System\Application\Vite\Vite;
use Nette\Bridges\ApplicationLatte\Template;

#[AllowDynamicProperties]
final class BaseTemplate extends Template
{
	public DayInfoDTO $dayInfoDTO;
	public Vite $vite;
}