<?php

declare(strict_types=1);

namespace app\Day\Domain\Entity;

use app\System\Domain\Entity\Entity;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="app\Day\Domain\Repository\DayRepository")
 * @ORM\Table(name="day")
 */
class Day extends Entity
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	protected ?int $id;
	/**
	 * @ORM\OneToOne(targetEntity="DayInfo")
	 */
	private DayInfo $dayInfo;
	/**
	 * @ORM\Column(type="date_immutable")
	 */
	private DateTimeImmutable $value;

	public function __construct()
	{
	}
}