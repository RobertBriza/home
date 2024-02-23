<?php

declare(strict_types=1);

namespace App\Rally\Domain\Model;

use App\Rally\Domain\Enum\MemberType;

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
