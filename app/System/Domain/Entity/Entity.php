<?php

declare(strict_types=1);

namespace App\System\Domain\Entity;

use App\Rally\Domain\Exception\PropertyNotSet;
use LogicException;

abstract class Entity
{
	protected ?int $id = null;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getIdChecked(): int
	{
		if ($this->id === null) {
			throw new PropertyNotSet('Entity has not been persisted yet.');
		}

		return $this->id;
	}

	public function setRemovedAt(\DateTimeImmutable $param): void
	{
		throw new LogicException('This entity cannot be removed.');
	}
}
