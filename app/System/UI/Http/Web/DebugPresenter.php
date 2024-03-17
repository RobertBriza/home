<?php

declare(strict_types=1);

namespace app\System\UI\Http\Web;

use app\Day\Application\Command\CreateDay;
use app\Day\Application\Helper\DayHelper;
use app\Day\Application\Query\GetDayDTOByValue;
use app\Day\Domain\DTO\DayDTO;
use app\Score\Domain\Score;
use Cycle\Database\DatabaseInterface;
use Cycle\ORM\ORM;
use DateTimeImmutable;

class DebugPresenter extends BasePresenter
{
	public function __construct(
		private readonly DatabaseInterface $database,
		private readonly ORM $orm,
	) {
	}

	public function actionCreateDay(): void
	{

		$dayData = [
			'date' => "2024-03-03",
			"dayInWeek" => "neděle",
			"dayNumber" => "3",
			"holidayName" => null,
			"isHoliday" => false,
			"month" => json_decode('{"nominative":"b\u0159ezen","genitive":"b\u0159ezna"}', true),
			"monthNumber" => "3",
			"name" => "Kamil",
			"year" => 2024,
		];

		$dayDTO = DayDTO::fromArray($dayData);
		$day = $this->mapper->map(new CreateDay($dayDTO));

		$this->em->persist($day);
		$this->em->flush();

		dumpe('saved');
	}

	public function actionCycle(): void
	{
		dumpe($this->orm->getRepository(Score::class)->findByPK(19));
	}

	public function actionGetDto(): void
	{
		$dayDTO = $this->mapper->map(new GetDayDTOByValue(new DateTimeImmutable("yesterday")));

	}

	public function actionTest(): void
	{
		dumpe(DayHelper::getWeekRange(new DateTimeImmutable("tomorrow")));

		dumpe("tuto");
	}
}
