<?php

declare(strict_types=1);

namespace app\System\Infrastructure;

use Cycle\Annotated\Embeddings;
use Cycle\Annotated\Entities;
use Cycle\Annotated\Locator\TokenizerEmbeddingLocator;
use Cycle\Annotated\Locator\TokenizerEntityLocator;
use Cycle\Annotated\MergeColumns;
use Cycle\Annotated\MergeIndexes;
use Cycle\Annotated\TableInheritance;
use Cycle\Database\DatabaseProviderInterface;
use Cycle\ORM\Collection\DoctrineCollectionFactory;
use Cycle\ORM\Collection\LoophpCollectionFactory;
use Cycle\ORM\Entity\Behavior\EventDrivenCommandGenerator;
use Cycle\ORM\Factory;
use Cycle\ORM\ORM;
use Cycle\ORM\Schema;
use Cycle\Schema\Compiler;
use Cycle\Schema\Generator\ForeignKeys;
use Cycle\Schema\Generator\GenerateModifiers;
use Cycle\Schema\Generator\GenerateRelations;
use Cycle\Schema\Generator\GenerateTypecast;
use Cycle\Schema\Generator\RenderModifiers;
use Cycle\Schema\Generator\RenderRelations;
use Cycle\Schema\Generator\RenderTables;
use Cycle\Schema\Generator\ResetTables;
use Cycle\Schema\Generator\ValidateEntities;
use Cycle\Schema\Registry;
use Doctrine\Common\Collections\Collection;
use Nette\Caching\Cache;
use Psr\Container\ContainerInterface;
use Spiral\Tokenizer\Config\TokenizerConfig;
use Spiral\Tokenizer\Tokenizer;

final class CycleOrmFactory
{
	public static function create(DatabaseProviderInterface $database, ContainerInterface $container, Cache $cache): ORM
	{
		$schema = $cache->load('cycle-schema');

		if ($schema === null) {
			$classLocator = (new Tokenizer(new TokenizerConfig([
				'directories' => [__APP_DIR__ . '/Score/Domain2'],
			])))->classLocator();

			$schema = (new Compiler())->compile(new Registry($database), [
				new ResetTables(),             // re-declared table schemas (remove columns)
				new Embeddings(new TokenizerEmbeddingLocator($classLocator)),        // register embeddable entities
				new Entities(new TokenizerEntityLocator($classLocator)),          // register annotated entities
				new TableInheritance(),               // register STI/JTI
				new MergeColumns(),                   // register columns from attributes
				new GenerateRelations(),       // generate entity relations
				new GenerateModifiers(),       // generate changes from schema modifiers
				new ValidateEntities(),        // make sure all entity schemas are correct
				new RenderTables(),            // declare table schemas
				new RenderRelations(),         // declare relation keys and indexes
				new RenderModifiers(),         // render all schema modifiers
				new ForeignKeys(),             // Define foreign key constraints
				new MergeIndexes(),                   // register indexes from attributes
				new GenerateTypecast(),        // typecast non string columns
			]);

			$cache->save('cycle-schema', $schema, [
				Cache::Expire => '1 day',
			]);
		}

		$commandGenerator = new EventDrivenCommandGenerator(new Schema($schema), $container);

		return new ORM(
			factory: (new Factory(
				dbal: $database,
				defaultCollectionFactory: new LoophpCollectionFactory(),
			))->withCollectionFactory(
				'doctrine',
				new DoctrineCollectionFactory(),
				Collection::class,
			),
			schema: new Schema($schema),
			commandGenerator: $commandGenerator,
		);
	}
}
