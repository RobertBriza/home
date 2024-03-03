<?php

declare(strict_types=1);

namespace app\Day\Domain\Entity;

use app\System\Domain\Entity\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="app\Day\Domain\Repository\DayInfoRepository")
 * @ORM\Table(name="day_info")
 */
class DayInfo extends Entity
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	public ?int $id;
	/**
	 * @ORM\OneToOne(
	 *   targetEntity="Day",
	 *   mappedBy="dayInfo",
	 *   cascade={"persist", "remove"}
	 * )
	 */
	protected Day $day;
	/**
	 * @ORM\Column(type="string")
	 */
	protected string $dayInWeek;
	/**
	 * @ORM\Column(type="string")
	 */
	protected string $dayNumber;
	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	protected ?string $holidayName = null;
	/**
	 * @ORM\Column(type="boolean")
	 */
	protected bool $isHoliday;
	/**
	 * @ORM\Column(type="json")
	 */
	protected array $month;
	/**
	 * @ORM\Column(type="string")
	 */
	protected string $monthNumber;
	/**
	 * @ORM\Column(type="string")
	 */
	protected string $name;
	/**
	 * @ORM\Column(type="string")
	 */
	protected string $year;

	public function getDay(): Day
	{
		return $this->day;
	}

	public function setDay(Day $day): void
	{
		$this->day = $day;
	}

	public function getDayInWeek(): string
	{
		return $this->dayInWeek;
	}

	public function setDayInWeek(string $dayInWeek): void
	{
		$this->dayInWeek = $dayInWeek;
	}

	public function getDayNumber(): string
	{
		return $this->dayNumber;
	}

	public function setDayNumber(string $dayNumber): void
	{
		$this->dayNumber = $dayNumber;
	}

	public function getHolidayName(): ?string
	{
		return $this->holidayName;
	}

	public function setHolidayName(?string $holidayName): void
	{
		$this->holidayName = $holidayName;
	}

	public function getMonth(): array
	{
		return $this->month;
	}

	public function setMonth(array $month): void
	{
		$this->month = $month;
	}

	public function getMonthNumber(): string
	{
		return $this->monthNumber;
	}

	public function setMonthNumber(string $monthNumber): void
	{
		$this->monthNumber = $monthNumber;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function setName(string $name): void
	{
		$this->name = $name;
	}

	public function getYear(): string
	{
		return $this->year;
	}

	public function setYear(string $year): void
	{
		$this->year = $year;
	}

	public function isHoliday(): bool
	{
		return $this->isHoliday;
	}

	public function setIsHoliday(bool $isHoliday): void
	{
		$this->isHoliday = $isHoliday;
	}
}