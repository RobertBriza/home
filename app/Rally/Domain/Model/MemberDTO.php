<?php

declare(strict_types=1);

namespace app\Rally\Domain\Model;

use app\Rally\Domain\Enum\MemberType;

readonly class MemberDTO
{
	public function __construct(
		public string $firstName,
		public string $lastName,
		public MemberType $type,
		public ?int $team = null,
	) {
	}
}
