<?php

declare(strict_types=1);

namespace app\System\Application\CQRS\Command;

use app\System\Application\Mapping\CommandEntityMapper;
use app\System\Application\Wiring\Autowired;
use Doctrine\ORM\EntityManagerInterface;

abstract class CommandHandler implements Autowired
{
	protected EntityManagerInterface $em;
	protected CommandEntityMapper $mapper;

	public function map(object $command): mixed
	{
		return $this->mapper->map($command);
	}

	public function persistAndFlush(object $command): void
	{
		$this->em->persist($this->mapper->map($command));
		$this->em->flush();
	}

	public function setEntityManager(EntityManagerInterface $em): void
	{
		$this->em = $em;
	}

	public function setMapper(CommandEntityMapper $mapper): void
	{
		$this->mapper = $mapper;
	}
}
