<?php

namespace app\System\Application\Mapping;

enum MappingMethod: string
{
	case Create = 'Create';
	case Delete = 'Delete';
	case Find = 'Find';
	case Get = 'Get';
	case Update = 'Update';
}