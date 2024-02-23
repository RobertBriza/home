<?php

declare(strict_types=1);

namespace App\Rally\Domain\Repository;

use App\Rally\Domain\Entity\Member;
use App\Rally\Domain\Enum\MemberType;
use App\System\Domain\Repository\BaseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @extends BaseRepository<Member>
 */
final class MemberRepository extends BaseRepository
{
	/** @return array<int, string> */
	public function findTeamMembersByType(MemberType $type): array
	{
		$query = $this->createQueryBuilder('m')
			->select('m')
			->where('m.type = :type')
			->setParameter('type', $type)
			->getQuery();

		$result = [];

		/** @var Member $entity */
		foreach ($query->getResult() as $entity) {
			$result[$entity->getIdChecked()] = $entity->getFirstName() . " " . $entity->getLastName();
		}

		return $result;
	}

	/**
	 * @param array<int> $ids
	 * @return Collection<int, Member>
	 */
	public function getEntitiesByIds(array $ids): Collection
	{
		$query = $this->createQueryBuilder('m')
			->select('m')
			->where('m.id IN (:ids)')
			->setParameter('ids', $ids)
			->getQuery();

		return new ArrayCollection($query->getResult());
	}
}
