<?php

namespace app\Day\Domain\Entity;

use app\System\Domain\Entity\Entity;
use Doctrine\ORM\Mapping as ORM;

/** @param array{
 *   dayNumber: string,
 *   dayInWeek: string,
 *   monthNumber: string,
 *   month: array,
 *   year: string,
 *   name: string,
 *   isHoliday: bool,
 *   holidayName: string
 * } $data
 */

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
	protected ?int $id;
	/**
	 * @ORM\Column(type="string")
	 */
	private string $dayInWeek;
	/**
	 * @ORM\OneToOne(targetEntity="Day")
	 */
	private DayInfo $dayInfo;
	/**
	 * @ORM\Column(type="string")
	 */
	private string $dayNumber;
	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private ?string $holidayName;
	/**
	 * @ORM\Column(type="boolean")
	 */
	private bool $isHoliday;
	/**
	 * @ORM\Column(type="json")
	 */
	private array $month;
	/**
	 * @ORM\Column(type="string")
	 */
	private string $monthNumber;
	/**
	 * @ORM\Column(type="string")
	 */
	private string $name;
	/**
	 * @ORM\Column(type="string")
	 */
	private string $year;
}