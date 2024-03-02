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
	 * @ORM\Column(type="string")
	 */
	public string $dayInWeek;
	/**
	 * @ORM\Column(type="string")
	 */
	public string $dayNumber;
	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	public ?string $holidayName;
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	public ?int $id;
	/**
	 * @ORM\Column(type="boolean")
	 */
	public bool $isHoliday;
	/**
	 * @ORM\Column(type="json")
	 */
	public array $month;
	/**
	 * @ORM\Column(type="string")
	 */
	public string $monthNumber;
	/**
	 * @ORM\Column(type="string")
	 */
	public string $name;
	/**
	 * @ORM\Column(type="string")
	 */
	public string $year;
}