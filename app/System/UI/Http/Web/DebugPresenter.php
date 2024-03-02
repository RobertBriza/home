<?php

declare(strict_types=1);

namespace app\System\UI\Http\Web;

use app\Day\Infrastructure\DayInfoProvider;
use DateTimeImmutable;

class DebugPresenter extends BasePresenter
{
	public function __construct(public DayInfoProvider $provider)
	{
	}

	public function actionDay(): void
	{
		$dayDTO = $this->provider->save(new DateTimeImmutable());

		dumpe($dayDTO);
	}
}
