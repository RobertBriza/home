<?php

namespace app\Day\Infrastructure;

use app\Day\Domain\DayInfoDTO;
use app\System\Application\Wiring\Autowired;
use DateTimeImmutable;
use GuzzleHttp\Client;
use Nette\Caching\Cache;
use Nette\Utils\JsonException;

final class DayInfoProvider implements Autowired
{
	public function __construct(
		private Client $dayInfoClient,
		private Cache $cache,
	) {
	}

	public function get(DateTimeImmutable $day): DayInfoDTO
	{
		$dateFormat = $day->format('Y-m-d');
		$contents = $this->cache->load(
			$dateFormat,
			function (&$dependencies) use ($dateFormat) {
				$dependencies[Cache::Expire] = '7 days';

				$uri = sprintf('api/day/%s', $dateFormat);
				$contents = $this->dayInfoClient->get($uri)->getBody()->getContents();

				if (json_validate($contents) === false) {
					throw new JsonException("Bad nameday I guess");
				}

				return json_decode($contents, flags: JSON_OBJECT_AS_ARRAY);
			},
		);

		return DayInfoDTO::fromArray((array) $contents);
	}
}