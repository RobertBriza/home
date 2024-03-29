<?php

declare(strict_types=1);

namespace app\System\Application\Routing\Factory;

use Nette;
use Nette\Application\Routers\RouteList;

final class RouterFactory
{
	use Nette\StaticClass;

	public static function createRouter(): RouteList
	{
		$router = new RouteList();

		$router->addRoute('/', 'Score:Score:default');
		$router->addRoute('/test', 'System:Homepage:default');

		$router->addRoute('<module>/<presenter>/<action>[/<id>]');

		return $router;
	}
}
