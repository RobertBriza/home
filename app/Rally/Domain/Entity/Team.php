<?php

declare(strict_types=1);

namespace app\Rally\Domain\Entity;

use app\Rally\Domain\Model\TeamDTO;
use app\System\Domain\Entity\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="app\Rally\Domain\Repository\TeamRepository")
 * @ORM\Table(name="team", uniqueConstraints={
 *       @ORM\UniqueConstraint(name="unique_name", columns={"name"})
 *   })
 */
class Team extends Entity
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	protected ?int $id;
	/**
	 * @ORM\ManyToMany(
	 *     targetEntity="app\Rally\Domain\Entity\Member",
	 *     inversedBy="teams",
	 *     cascade={"persist", "remove"}
	 * )
	 * @ORM\JoinTable(name="team_members")
	 * @var Collection<int, Member>
	 */
	private Collection $members;
	/**
	 * @ORM\Column(type="string", length=64)
	 */
	private string $name;

	public function __construct()
	{
		$this->members = new ArrayCollection();
	}

	public function addMember(Member $member): self
	{
		if (! $this->members->contains($member)) {
			$this->members->add($member);
			$member->addTeam($this);
		}

		return $this;
	}

	/** @return Collection<int, Member> */
	public function getMembers(): Collection
	{
		return $this->members;
	}

	/** @param Collection<int, Member> $members */
	public function setMembers(Collection $members): self
	{
		$this->members = $members;

		return $this;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function setName(string $name): self
	{
		$this->name = $name;

		return $this;
	}

	public function removeMember(Member $member): self
	{
		if ($this->members->contains($member)) {
			$this->members->removeElement($member);
			$member->removeTeam($this);
		}

		return $this;
	}

	public function toDTO(): TeamDTO
	{
		return new TeamDTO(
			$this->getName(),
			$this->getMembers()->map(fn (Member $member) => $member->toDTO()),
		);
	}
}
