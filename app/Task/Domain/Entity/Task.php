<?php

declare(strict_types=1);

namespace app\Task\Domain\Entity;

use app\Task\Domain\Enum\TaskPriority;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass="app\Task\Domain\Repository\TaskRepository")
 * @ORM\Table(name="task")
 */
class Task
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="uuid", unique=true)
	 * @ORM\GeneratedValue(strategy="CUSTOM")
	 * @ORM\CustomIdGenerator(class=UuidGenerator::class)
	 */
	protected UuidInterface $id;
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
	 * @ORM\Column(type="string", enumType=TaskPriority::class, length=16)
	 */
	private TaskPriority $priority;
	/**
	 * @ORM\Column(type="integer")
	 */
	private int $taskOrder;
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

	public function setDeletedAt(?DateTimeImmutable $deletedAt): void
	{
		$this->deletedAt = $deletedAt;
	}

	public function getDescription(): ?string
	{
		return $this->description;
	}

	public function setDescription(?string $description): void
	{
		$this->description = $description;
	}

	public function getDueDatetime(): ?DateTimeImmutable
	{
		return $this->dueDatetime;
	}

	public function setDueDatetime(?DateTimeImmutable $dueDatetime): void
	{
		$this->dueDatetime = $dueDatetime;
	}

	public function getId(): UuidInterface
	{
		return $this->id;
	}

	public function getPriority(): TaskPriority
	{
		return $this->priority;
	}

	public function setPriority(TaskPriority $priority): void
	{
		$this->priority = $priority;
	}

	public function getTaskOrder(): int
	{
		return $this->taskOrder;
	}

	public function setTaskOrder(int $taskOrder): void
	{
		$this->taskOrder = $taskOrder;
	}

	public function getTitle(): string
	{
		return $this->title;
	}

	public function setTitle(string $title): void
	{
		$this->title = $title;
	}

	public function getUpdatedAt(): DateTimeImmutable
	{
		return $this->updatedAt;
	}

	public function setUpdatedAt(DateTimeImmutable $createdAt): void
	{
		$this->updatedAt = $createdAt;
	}

	public function getUpdatedBy(): ?DateTimeImmutable
	{
		return $this->updatedBy;
	}

	public function setUpdatedBy(?DateTimeImmutable $updatedBy): void
	{
		$this->updatedBy = $updatedBy;
	}
}
