<?php
namespace ProfiCloS;

use function call_user_func;

class LatteFilterService
{

	public function format($input, $function, ...$args)
	{
		return call_user_func([Format::class, $function], $input, ...$args);
	}

}
