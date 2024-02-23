<?php

declare(strict_types=1);

namespace App\System\UI\Http\Web;

use App\Rally\Application\Command\DeleteMember;
use App\Rally\Application\Command\UpdateMember;
use App\Rally\Application\Command\UpdateTeam;
use App\Rally\Domain\Enum\MemberType;
use Nette\Application\Responses\JsonResponse;

class DebugPresenter extends BasePresenter
{
	public function actionDeleteMember(): void
	{
		$this->bus->sendCommand(new DeleteMember(
			id: 47,
		));
	}

	public function actionUpdateMember(): void
	{
		$this->bus->sendCommand(new UpdateMember(
			id: 16,
			firstName: 'Juna',
			lastName: 'Dobre',
			type: MemberType::Driver,
			teams: [1, 2, 3, 4],
		));

		$this->sendResponse(new JsonResponse([
			'status' => 'ok',
		]));
	}

	public function actionUpdateTeam(): void
	{
		$this->bus->sendCommand(new UpdateTeam(
			id: 1,
			name: 'Team Auto',
			members: [1, 2, 3, 4, 5, 6], //1,2,5,9,12,15,16
		));

		$this->sendResponse(new JsonResponse([
			'status' => 'ok',
		]));
	}
}
