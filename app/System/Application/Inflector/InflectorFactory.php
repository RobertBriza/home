<?php

declare(strict_types=1);

namespace app\System\Application\Inflector;

use Doctrine\Inflector\Inflector;

final class InflectorFactory
{
	public static function create(): Inflector
	{
		return \Doctrine\Inflector\InflectorFactory::create()->build();
	}
}
