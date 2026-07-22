<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Exception;

use RuntimeException;

/**
 * Raised when a resolved config recipe cannot be applied to a component.
 *
 * Usage example:
 * ```php
 * use UIAwesome\Html\Core\Exception\ConfigException;
 *
 * try {
 *     $applier->apply($component, $recipe, $context);
 * } catch (ConfigException $e) {
 *     // handle the exception, for example, log the error or provide a fallback.
 * }
 * ```
 */
final class ConfigException extends RuntimeException {}
