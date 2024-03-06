<?php

declare(strict_types=1);

namespace app\System\UI\Cli;

use app\Day\Application\Query\GetDayDTOByValue;
use app\Day\Domain\DTO\DayDTO;
use app\Day\Infrastructure\DayInfoProvider;
use app\System\Application\CQRS\CQRS;
use app\System\Application\CQRS\CQRSAble;
use app\System\Application\Wiring\Autowired;
use DateTimeImmutable;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: self::NAME)]
class SaveDayInfoCommand extends Command implements Autowired, CQRSAble
{
	use CQRS;

	public const NAME = 'day:save-info';

	public function __construct(private DayInfoProvider $provider)
	{
		parent::__construct();
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln('<info>Fetching day info</info>');

		$date = $modifiedDate = new DateTimeImmutable();

		for ($i = $y = 0; $y < 60; $i++) {
			/** @var DayDTO $dto */
			$dto = $this->sendQuery(new GetDayDTOByValue($modifiedDate));

			if ($dto === null) {
				$this->provider->save($modifiedDate);
				$y++;
			}

			$modifiedDate = $date->modify("-$i days");
		}

		$output->writeln('<info>Config files has been generated successfully!</info>');

		return Command::SUCCESS;
	}
}