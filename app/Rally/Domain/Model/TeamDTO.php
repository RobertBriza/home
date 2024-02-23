<?php

declare(strict_types=1);

namespace app\Rally\Domain\Model;

use Doctrine\Common\Collections\Collection;

readonly class TeamDTO
{
	/** @param Collection<int, MemberDTO> $members */
	public function __construct(
		public string $name,
		public Collection $members,
	) {
	}
}
