<?php

declare(strict_types=1);

namespace app\System\UI\Cli;

use app\Day\Infrastructure\DayInfoProvider;
use app\System\Application\Wiring\Autowired;
use DateTimeImmutable;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: self::NAME)]
class SaveDayInfoCommand extends Command implements Autowired
{
	public const NAME = 'day:save-info';

	public function __construct(private DayInfoProvider $provider)
	{
		parent::__construct();
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln('<info>Fetching day info</info>');

		$this->provider->save(new DateTimeImmutable());

		$output->writeln('<info>Config files has been generated successfully!</info>');

		return Command::SUCCESS;
	}
}