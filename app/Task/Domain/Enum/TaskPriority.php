<?php

namespace app\Task\Domain\Enum;

enum TaskPriority: string
{
	case LOW = 'low';
	case MEDIUM = 'medium';
	case HIGH = 'high';

	/** @return array<string, string> */
	public static function valuesForSelect(): array
	{
		return [
			self::LOW->value => 'Nízká',
			self::MEDIUM->value => 'Střední',
			self::HIGH->value => 'Vysoká',
		];
	}

	public function getCssClass(): string
	{
		return match ($this) {
			self::LOW => 'border-green-500',
			self::MEDIUM => 'border-yellow-500',
			self::HIGH => 'border-red-500',
		};
	}
}
