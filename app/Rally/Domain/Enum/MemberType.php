<?php

declare(strict_types=1);

namespace App\Rally\Domain\Enum;

use Exception;

enum MemberType: string
{
	case Driver = 'driver';
	case CoDriver = 'codriver';
	case Technician = 'technician';
	case Manager = 'manager';
	case Photographer = 'photographer';

	public function exceededMax(int $count): bool
	{
		[$min, $max] = $this->getMinMaxForMultiSelect();

		return $count > $max;
	}

	public function getInfo(): string
	{
		return \sprintf("Minimálně %s, maximálně %s", ...$this->getMinMaxForMultiSelect());
	}

	public function getLang(): string
	{
		return 'member.' . $this->value;
	}

	public function getMaxErrorLang(): string
	{
		match ($this) {
			self::Driver, self::CoDriver => $lang = 'field.member.max.three',
			self::Technician => $lang = 'field.member.max.two',
			self::Manager, self::Photographer => $lang = 'field.member.max.one',
		};

		return $lang ?? throw new Exception(sprintf("No max error lang for %s", $this::class));
	}

	/** @return int[] */
	public function getMinMaxForMultiSelect(): array
	{
		match ($this) {
			self::Driver, self::CoDriver => $limits = [1, 3],
			self::Technician => $limits = [1, 2],
			self::Manager => $limits = [1, 1],
			self::Photographer => $limits = [0, 1],
		};

		return $limits ?? throw new Exception(sprintf("No min max for %s", $this::class));
	}
}
