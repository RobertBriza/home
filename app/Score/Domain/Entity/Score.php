<?php

declare(strict_types=1);

namespace app\Score\Domain\Entity;

use app\System\Domain\Entity\Entity;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="app\Score\Domain\Repository\ScoreRepository")
 * @ORM\Table(name="score")
 */
class Score extends Entity
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	protected ?int $id;
	/**
	 * @ORM\Column(type="datetime_immutable")
	 */
	private DateTimeImmutable $createdAt;
	/**
	 * @ORM\Column(type="integer")
	 */
	private int $score1;
	/**
	 * @ORM\Column(type="integer")
	 */
	private int $score2;

	public function __construct()
	{

	}

	public function getId(): int
	{
		return $this->id;
	}

	public function getScore1(): int
	{
		return $this->score1;
	}

	public function setScore1(int $score1): void
	{
		$this->score1 = $score1;
	}

	public function getScore2(): int
	{
		return $this->score2;
	}

	public function setScore2(int $score2): void
	{
		$this->score2 = $score2;
	}
}
