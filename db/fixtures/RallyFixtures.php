<?php

namespace db\fixtures;

use App\Rally\Domain\Entity\Member;
use App\Rally\Domain\Entity\Team;
use App\Rally\Domain\Enum\MemberType;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class RallyFixtures extends AbstractFixture
{
	/**
	 * @inheritDoc
	 */
	public function load(ObjectManager $manager)
	{
		$jakub = new Member();
		$jakub->setFirstName('Jakub');
		$jakub->setLastName('Jezdec');
		$jakub->setType(MemberType::Driver);
		$manager->persist($jakub);

		$karel = new Member();
		$karel->setFirstName('Karel');
		$karel->setLastName('Kamikaze');
		$karel->setType(MemberType::Driver);
		$manager->persist($karel);

		$pepa = new Member();
		$pepa->setFirstName('Pepa');
		$pepa->setLastName('Pocahontas');
		$pepa->setType(MemberType::Driver);
		$manager->persist($pepa);

		$miroslav = new Member();
		$miroslav->setFirstName('Miroslav');
		$miroslav->setLastName('Meteorit');
		$miroslav->setType(MemberType::Driver);
		$manager->persist($miroslav);

		$stepan = new Member();
		$stepan->setFirstName('Štěpán');
		$stepan->setLastName('Šunkaflek');
		$stepan->setType(MemberType::CoDriver);
		$manager->persist($stepan);

		$filip = new Member();
		$filip->setFirstName('Filip');
		$filip->setLastName('Fatamorgána');
		$filip->setType(MemberType::CoDriver);
		$manager->persist($filip);

		$lukas = new Member();
		$lukas->setFirstName('Lukáš');
		$lukas->setLastName('Lokomotiva');
		$lukas->setType(MemberType::CoDriver);
		$manager->persist($lukas);

		$karolina = new Member();
		$karolina->setFirstName('Karolína');
		$karolina->setLastName('Kočárková');
		$karolina->setType(MemberType::CoDriver);
		$manager->persist($karolina);

		$martin = new Member();
		$martin->setFirstName('Martin');
		$martin->setLastName('Mascarpone');
		$martin->setType(MemberType::Technician);
		$manager->persist($martin);

		$daniel = new Member();
		$daniel->setFirstName('Daniel');
		$daniel->setLastName('Diagnostika');
		$daniel->setType(MemberType::Technician);
		$manager->persist($daniel);

		$marek = new Member();
		$marek->setFirstName('Marek');
		$marek->setLastName('Mechanismus');
		$marek->setType(MemberType::Technician);
		$manager->persist($marek);

		$honza = new Member();
		$honza->setFirstName('Honza');
		$honza->setLastName('Brynza');
		$honza->setType(MemberType::Manager);
		$manager->persist($honza);

		$alena = new Member();
		$alena->setFirstName('Alena');
		$alena->setLastName('Aligátor');
		$alena->setType(MemberType::Manager);
		$manager->persist($alena);

		$petr = new Member();
		$petr->setFirstName('Petr');
		$petr->setLastName('Produktivita');
		$petr->setType(MemberType::Manager);
		$manager->persist($petr);

		$emanuel = new Member();
		$emanuel->setFirstName('Emanuel');
		$emanuel->setLastName('Aliterace');
		$emanuel->setType(MemberType::Manager);

		$lojza = new Member();
		$lojza->setFirstName('Lojza');
		$lojza->setLastName('Laskomina');
		$lojza->setType(MemberType::Photographer);
		$manager->persist($lojza);

		$roman = new Member();
		$roman->setFirstName('Roman');
		$roman->setLastName('Rámeček');
		$roman->setType(MemberType::Photographer);
		$manager->persist($roman);

		$milos = new Member();
		$milos->setFirstName('Miloš');
		$milos->setLastName('Momentka');
		$milos->setType(MemberType::Photographer);
		$manager->persist($milos);

		$teamA = new Team();
		$teamA->setName('Team A')
			->addMember($jakub)
			->addMember($karel)
			->addMember($stepan)
			->addMember($martin)
			->addMember($honza)
			->addMember($lojza);
		$manager->persist($teamA);

		$teamB = new Team();
		$teamB->setName('Team B')
			->addMember($pepa)
			->addMember($miroslav)
			->addMember($filip)
			->addMember($daniel)
			->addMember($alena)
			->addMember($roman);
		$manager->persist($teamB);

		$teamC = new Team();
		$teamC->setName('Team C')
			->addMember($jakub)
			->addMember($karel)
			->addMember($lukas)
			->addMember($stepan)
			->addMember($daniel)
			->addMember($marek)
			->addMember($petr)
			->addMember($roman);
		$manager->persist($teamC);

		$teamD = new Team();
		$teamD->setName('Team D')
			->addMember($miroslav)
			->addMember($karolina)
			->addMember($filip)
			->addMember($martin)
			->addMember($emanuel)
			->addMember($milos);
		$manager->persist($teamD);

		$manager->flush();
	}
}