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
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	public ?int $id;
	/**
	 * @ORM\OneToOne(
	 *   targetEntity="DayInfo",
	 *   inversedBy="day",
	 *   cascade={"persist", "remove"}
	 * )
	 * @ORM\JoinColumn(name="day_info_id", referencedColumnName="id")
	 */
	protected DayInfo $dayInfo;
	/**
	 * @ORM\Column(type="date_immutable")
	 */
	protected DateTimeImmutable $value;

	public function __construct()
	{
	}

	public function getDayInfo(): DayInfo
	{
		return $this->dayInfo;
	}

	public function setDayInfo(DayInfo $dayInfo): void
	{
		$this->dayInfo = $dayInfo;
	}

	public function getValue(): DateTimeImmutable
	{
		return $this->value;
	}

	public function setValue(DateTimeImmutable $value): void
	{
		$this->value = $value;
	}
}