<?php

declare(strict_types=1);

namespace App\System\Application\Routing\Factory;

use Nette;
use Nette\Application\Routers\RouteList;

final class RouterFactory
{
	use Nette\StaticClass;

	public static function createRouter(): RouteList
	{
		$router = new RouteList();

		$router->addRoute('/', 'System:Homepage:default');

		$router->addRoute('<module>/<presenter>/<action>[/<id>]');

		return $router;
	}
}
