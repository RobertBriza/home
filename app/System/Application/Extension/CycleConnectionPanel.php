<?php declare(strict_types=1);

namespace app\System\Application\Extension;

use Psr\Log\LoggerInterface;
use Tracy\IBarPanel;

class CycleConnectionPanel implements IBarPanel, LoggerInterface
{
	/** @var int */
	private $count = 0;
	/** @var int */
	private $maxQueries = 100;
	/**
	 * @var array
	 * @phpstan-var array<array{IConnection, string, float, ?int}>
	 */
	private $queries = [];
	/** @var float */
	private $totalTime;

	#[Override]
	public function alert(\Stringable|string $message, array $context = []): void
	{
		$this->logQuery('CHYBA: ' . $message, 0, null);
	}

	#[Override]
	public function critical(\Stringable|string $message, array $context = []): void
	{
		bdump($message);
	}

	#[Override]
	public function debug(\Stringable|string $message, array $context = []): void
	{
		bdump($message);
	}

	#[Override]
	public function emergency(\Stringable|string $message, array $context = []): void
	{
		bdump($message);
	}

	#[Override]
	public function error(\Stringable|string $message, array $context = []): void
	{
		$this->logQuery($message, 0, null);
	}

	public function getPanel(): string
	{
		$count = $this->count;
		$queries = $this->queries;
		$queries = array_map(function ($row): array {
			try {
				$row[4] = null;
			} catch (\Throwable $e) {
				$row[4] = null;
				$row[3] = null; // rows count is also irrelevant
			}

			return $row;
		}, $queries);

		ob_start();
		require __DIR__ . '/CycleConnectionPanel.panel.phtml';

		return (string) ob_get_clean();
	}

	public function getTab(): string
	{
		$count = $this->count;
		$totalTime = $this->totalTime;

		ob_start();
		require __DIR__ . '/CycleConnectionPanel.tab.phtml';

		return (string) ob_get_clean();
	}

	#[Override]
	public function info(\Stringable|string $message, array $context = []): void
	{
		$this->logQuery($message, $context['elapsed'] ?? 0, $context['rowCount'] ?? null);
	}

	#[Override]
	public function log($level, \Stringable|string $message, array $context = []): void
	{
		bdump($message);
	}

	public function logQuery(string $sqlQuery, float $timeTaken, ?int $rowCount): void
	{
		$this->count++;
		if ($this->count > $this->maxQueries) {
			return;
		}

		$this->totalTime += $timeTaken;
		$this->queries[] = [
			$sqlQuery,
			$timeTaken,
			$rowCount,
		];
	}

	#[Override]
	public function notice(\Stringable|string $message, array $context = []): void
	{
		bdump($message);
	}

	#[Override]
	public function warning(\Stringable|string $message, array $context = []): void
	{
		bdump($message);
	}
}
