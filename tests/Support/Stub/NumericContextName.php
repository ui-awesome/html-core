<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Stub;

/**
 * Integer-backed component context name rejected by the string-only name contract.
 */
enum NumericContextName: int
{
    case ONE = 1;
}
