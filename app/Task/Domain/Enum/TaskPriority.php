<?php

namespace app\Task\Domain\Enum;

enum TaskPriority: string
{
	case LOW = 'low';
	case MEDIUM = 'medium';
	case HIGH = 'high';

	public function getCssClass(): string
	{
		return match ($this) {
			self::LOW => 'border-green-500',
			self::MEDIUM => 'border-yellow-500',
			self::HIGH => 'border-red-500',
		};
	}
}
