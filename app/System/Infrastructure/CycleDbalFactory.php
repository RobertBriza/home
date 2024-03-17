<?php

declare(strict_types=1);

namespace app\System\Infrastructure;

use Cycle\Database\Config\DatabaseConfig;
use Cycle\Database\Config\Postgres\DsnConnectionConfig;
use Cycle\Database\Config\PostgresDriverConfig;
use Cycle\Database\DatabaseInterface;
use Cycle\Database\DatabaseManager;
use Cycle\Database\DatabaseProviderInterface;
use Psr\Log\LoggerInterface;

final class CycleDbalFactory implements DatabaseProviderInterface
{
	private readonly DatabaseManager $databaseManager;

	/**
	 * @param array<mixed> $config
	 */
	public function __construct(array $config)
	{
		$databaseList = [];
		$connectionList = [];
		foreach ($config['connection'] as $key => $connection) {
			$databaseList[$key] = [
				'connection' => $key,
			];

			$connectionList[$key] = new PostgresDriverConfig(
				connection: new DsnConnectionConfig(
					dsn: (string) $connection['dsn'],
					user: (string) $connection['user'],
					password: (string) $connection['password'],
				),
				queryCache: $connection['queryCache'],
				options: [
					'logQueryParameters' => true,
				],
			);
		}

		$this->databaseManager = new DatabaseManager(
			new DatabaseConfig([
				'default' => 'default',
				'databases' => $databaseList,
				'connections' => $connectionList,
			]),
		);
	}

	public function connection(string $connection): DatabaseInterface
	{
		return $this->databaseManager->database($connection);
	}

	#[\Override]
	public function database(string $database = null): DatabaseInterface
	{
		return $this->databaseManager->database($database);
	}

	public function setLogger(LoggerInterface $logger): void
	{
		$this->databaseManager->setLogger($logger);
	}
}
