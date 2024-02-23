<?php

declare(strict_types=1);

namespace App\System\Application\CQRS\Command;

use App\System\Application\Mapping\CommandEntityMapper;
use App\System\Application\Wiring\Autowired;
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
