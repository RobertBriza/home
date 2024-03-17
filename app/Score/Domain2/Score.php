<?php

declare(strict_types=1);

namespace app\Score\Domain;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use DateTimeImmutable;

#[Entity(
	role: 'score',
	table: 'public.score',
	database: 'default'
)]
class Score
{
	#[Column(type: 'timestamp', name: 'created_at', nullable: false)]
	private DateTimeImmutable $createdAt;
	#[Column(type: 'primary')]
	private int $id;
	#[Column(type: 'integer', nullable: false, default: false)]
	private int $score1;
	#[Column(type: 'integer', nullable: false, default: false)]
	private int $score2;

	public function createdAt(): DateTimeImmutable
	{
		return $this->createdAt;
	}

	public function id(): int
	{
		return $this->id;
	}

	public function score1(): int
	{
		return $this->score1;
	}

	public function score2(): int
	{
		return $this->score2;
	}
}
