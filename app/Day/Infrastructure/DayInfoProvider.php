<?php

declare(strict_types=1);

namespace app\Day\Infrastructure;

use app\Day\Application\Command\CreateDay;
use app\Day\Application\Query\GetDayDTOByValue;
use app\Day\Domain\DTO\DayDTO;
use app\System\Application\CQRS\CQRS;
use app\System\Application\CQRS\CQRSAble;
use app\System\Application\Wiring\Autowired;
use DateTimeImmutable;
use GuzzleHttp\Client;
use Nette\Caching\Cache;
use Nette\Utils\JsonException;

final class DayInfoProvider implements CQRSAble, Autowired
{
	use CQRS;

	public function __construct(
		private Client $dayInfoClient,
		private Cache $cache,
	) {
	}

	public function save(DateTimeImmutable $dateTime): void
	{
		$day = $this->sendQuery(new GetDayDTOByValue($dateTime));

		if ($day !== null) {
			return;
		}

		$dto = DayDTO::fromArray($this->getApi($dateTime));

		$this->cache->save(
			'dayInfo' . $dateTime->format('Y-m-d'),
			$dto,
			[Cache::Expire => '30 days'],
		);

		$this->sendCommand(new CreateDay($dto));
	}

	private function getApi(DateTimeImmutable $dateTime): array
	{
		$dateFormat = $dateTime->format('Y-m-d');

		$uri = sprintf('api/day/%s', $dateFormat);
		$contents = $this->dayInfoClient->get($uri)->getBody()->getContents();

		if (json_validate($contents) === false) {
			throw new JsonException("Bad nameday I guess");
		}

		return json_decode($contents, flags: JSON_OBJECT_AS_ARRAY);
	}
}