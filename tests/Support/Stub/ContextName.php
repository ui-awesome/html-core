<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Tests\Support\Stub;

/**
 * String-backed component context names used to verify enum normalization.
 */
enum ContextName: string
{
    case ALERT = 'alert';

    case DANGER = 'danger';

    case DARK = 'dark';

    case DISMISSIBLE = 'dismissible';

    case EMPTY = '';

    case LARGE = 'lg';

    case WHITESPACE = 'field control';
}
