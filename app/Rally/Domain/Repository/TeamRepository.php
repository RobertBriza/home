<?php

declare(strict_types=1);

namespace app\Rally\Domain\Repository;

use app\Rally\Domain\Entity\Team;
use app\Rally\Domain\Enum\MemberType;
use app\System\Domain\Repository\BaseRepository;

/**
 * @extends BaseRepository<Team>
 */
final class TeamRepository extends BaseRepository
{
	/** @return array<int, Team> */
	public function findAllSortedByType(): array
	{
		return $this->createQueryBuilder('t')
			->select('t', 'm')
			->leftJoin('t.members', 'm')
			->orderBy('t.name', 'ASC')
			->addOrderBy('FIELD(m.type, :types)')
			->setParameter('types', array_map(fn (MemberType $type) => $type->value, MemberType::cases()))
			->getQuery()
			->getResult();
	}

	/** @return array<int, string> */
	public function getIdNamePairs(): array
	{
		$query = $this->createQueryBuilder('t')
			->select('t.id', 't.name')
			->getQuery();

		$associativeResult = [];

		foreach ($query->toIterable() as $row) {
			$associativeResult[(int) $row['id']] = (string) $row['name'];
		}

		return $associativeResult;
	}

	public function getOneSortedByType(int $id): ?Team
	{
		return $this->createQueryBuilder('t')
			->select('t', 'm')
			->leftJoin('t.members', 'm')
			->where('t.id = :id')
			->orderBy('t.name', 'ASC')
			->addOrderBy('FIELD(m.type, :types)')
			->setParameter('id', $id)
			->setParameter('types', array_map(fn (MemberType $type) => $type->value, MemberType::cases()))
			->getQuery()
			->getOneOrNullResult();
	}
}
