<?php

declare(strict_types=1);

namespace app\System\Application\Extension;

use app\System\Infrastructure\CycleDbalFactory;
use Nette\DI\CompilerExtension;
use Nette\DI\Definitions\Statement;
use Nette\Schema\Expect;
use Nette\Schema\Schema as NetteSchema;

final class CycleOrmExtension extends CompilerExtension
{
	public function getConfigSchema(): NetteSchema
	{
		return Expect::structure([
			'connection' => Expect::arrayOf(
				Expect::structure([
					'dsn' => Expect::string()->required(),
					'user' => Expect::type(Statement::class)->default(''),
					'password' => Expect::type(Statement::class)->default(''),
					'queryCache' => Expect::bool()->default(false),
				])->castTo('array'),
			),
			'entityDirectory' => Expect::string()->required(),
			'cacheDirectory' => Expect::string()->nullable(),
			'logger' => Expect::anyOf(
				Expect::string(),
				Expect::type(Statement::class),
			)->nullable(),
		])->castTo('array');
	}

	public function loadConfiguration(): void
	{
		$builder = $this->getContainerBuilder();
		/** @var \stdClass $config */
		$config = $this->getConfig();

		$builder->addDefinition($this->prefix('factory'))
			->setFactory(CycleDbalFactory::class, [$config])
			->addSetup('setLogger', ['@cycle.logger']);
	}
}
