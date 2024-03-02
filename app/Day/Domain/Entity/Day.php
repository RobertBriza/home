<?php

declare(strict_types=1);

namespace app\Day\Domain\Entity;

use app\System\Domain\Entity\Entity;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="app\Day\Domain\Repository\DayRepository")
 * @ORM\Table(name="day", uniqueConstraints={
 *       @ORM\UniqueConstraint(name="unique_value", columns={"value"})
 *   }))
 */
class Day extends Entity
{
	/**
	 * @ORM\OneToOne(
	 *   targetEntity="DayInfo",
	 *   cascade={"persist", "remove"}
	 * )
	 */
	public DayInfo $dayInfo;
	/**
	 * @ORM\Column(type="date_immutable")
	 */
	public DateTimeImmutable $value;
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	protected ?int $id;

	public function __construct()
	{
	}
}