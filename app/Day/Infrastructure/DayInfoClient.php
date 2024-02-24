<?php

namespace app\Day\Infrastructure;

use GuzzleHttp\Client;

final class DayInfoClient
{
	public static function create(): Client
	{
		return new Client([
			'base_uri' => 'https://svatkyapi.cz/',
			'headers' => [
				'Accept' => 'application/json',
				'Content-Type' => 'application/json',
			],
		]);
	}
}