<?php

declare(strict_types=1);

namespace app\System\Application\Helper;

final class TransformClassName
{
	public static function dtoToEntity($dtoClassName): string
	{
		$entityClassName = str_replace('\DTO\\', '\Entity\\', $dtoClassName);

		if (substr($entityClassName, -3) === 'DTO') {
			$entityClassName = substr($entityClassName, 0, -3);
		}

		return $entityClassName;
	}

	public static function entityToDTO($entityClassName): string
	{
		return str_replace('\Entity\\', '\DTO\\', $entityClassName) . 'DTO';
	}
}
