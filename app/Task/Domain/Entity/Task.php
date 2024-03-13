<?php

declare(strict_types=1);

namespace app\Task\Domain\Entity;

use app\Task\Domain\Enum\TaskPriority;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="app\Task\Domain\Repository\TaskRepository")
 * @ORM\Table(name="task")
 */
class Task
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="uuid")
	 */
	protected ?int $id;
	/**
	 * @ORM\Column(type="datetime_immutable", nullable=true)
	 */
	private ?DateTimeImmutable $deletedAt = null;
	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	private ?string $description = null;
	/**
	 * @ORM\Column(type="datetime_immutable", nullable=true)
	 */
	private ?DateTimeImmutable $dueDatetime = null;
	/**
	 * @ORM\Column(type="integer")
	 */
	private int $order;
	/**
	 * @ORM\Column(type="string", enumType=TaskPriority::class, length=16)
	 */
	private TaskPriority $priority;
	/**
	 * @ORM\Column(type="string")
	 */
	private string $title;
	/**
	 * @ORM\Column(type="datetime_immutable")
	 */
	private DateTimeImmutable $updatedAt;
	/**
	 * @ORM\Column(type="string", nullable=true)
	 */
	private ?DateTimeImmutable $updatedBy = null;

	public function getDeletedAt(): ?DateTimeImmutable
	{
		return $this->deletedAt;
	}

	public function getDescription(): ?string
	{
		return $this->description;
	}

	public function getDueDatetime(): ?DateTimeImmutable
	{
		return $this->dueDatetime;
	}

	public function getOrder(): int
	{
		return $this->order;
	}

	public function getPriority(): TaskPriority
	{
		return $this->priority;
	}

	public function getTitle(): string
	{
		return $this->title;
	}

	public function getUpdatedAt(): DateTimeImmutable
	{
		return $this->updatedAt;
	}

	public function getUpdatedBy(): ?DateTimeImmutable
	{
		return $this->updatedBy;
	}
}
