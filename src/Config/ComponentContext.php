<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Config;

use InvalidArgumentException;
use UIAwesome\Html\Core\Exception\Message;

use function array_is_list;
use function array_key_exists;
use function in_array;
use function is_string;
use function preg_match;

/**
 * Describes the semantic component and qualifiers used to resolve config recipes.
 *
 * Usage example:
 * ```php
 * $context = new \UIAwesome\Html\Core\Config\ComponentContext(
 *     'field.control.email',
 *     variant: 'floating',
 *     size: 'medium',
 *     states: ['invalid'],
 * );
 * ```
 */
final readonly class ComponentContext
{
    /**
     * Extensible semantic metadata available to config providers.
     *
     * Object values are stored by reference, so pass immutable values when deep immutability is required.
     *
     * @var array<string, mixed>
     */
    public array $metadata;
    /**
     * Active component states.
     *
     * @var list<string>
     */
    public array $states;

    /**
     * @param string $component Semantic component identifier, for example `field.control.email`.
     * @param string|null $variant Optional presentation variant.
     * @param string|null $size Optional component size.
     * @param string|null $scheme Optional color scheme.
     * @param array<array-key, mixed> $states Active component states.
     * @param array<array-key, mixed> $metadata Additional semantic metadata.
     *
     * @throws InvalidArgumentException If the component identifier or a qualifier is empty or contains whitespace, the
     * states are not a list of non-empty strings, or a metadata key is not a non-empty string.
     */
    public function __construct(
        public string $component,
        public string|null $variant = null,
        public string|null $size = null,
        public string|null $scheme = null,
        array $states = [],
        array $metadata = [],
    ) {
        $this->assertName($component, 'Component identifier');
        $this->assertOptionalName($variant, 'Variant');
        $this->assertOptionalName($size, 'Size');
        $this->assertOptionalName($scheme, 'Scheme');

        if (array_is_list($states) === false) {
            throw new InvalidArgumentException(
                Message::COMPONENT_STATES_MUST_BE_STRING_LIST->getMessage(),
            );
        }

        $normalizedStates = [];

        foreach ($states as $state) {
            if (is_string($state) === false) {
                throw new InvalidArgumentException(
                    Message::COMPONENT_STATES_MUST_BE_STRING_LIST->getMessage(),
                );
            }

            $this->assertName($state, 'Component state');

            $normalizedStates[] = $state;
        }

        $normalizedMetadata = [];

        foreach ($metadata as $key => $value) {
            if (is_string($key) === false || $key === '') {
                throw new InvalidArgumentException(
                    Message::COMPONENT_METADATA_KEYS_MUST_BE_NON_EMPTY_STRINGS->getMessage(),
                );
            }

            $normalizedMetadata[$key] = $value;
        }

        $this->metadata = $normalizedMetadata;
        $this->states = $normalizedStates;
    }

    /**
     * Returns semantic metadata or the provided default value.
     *
     * Usage example:
     * ```php
     * $maxLength = $context->get('maxlength', 255);
     * ```
     *
     * @param string $key Metadata key to look up.
     * @param mixed $default Value returned when the key is missing.
     *
     * @return mixed Stored metadata value, or the default when the key is missing.
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return array_key_exists($key, $this->metadata) ? $this->metadata[$key] : $default;
    }

    /**
     * Whether the component has the specified state.
     *
     * Usage example:
     * ```php
     * $isInvalid = $context->hasState('invalid');
     * ```
     *
     * @param string $state State name to check.
     *
     * @return bool `true` if the state is active, `false` otherwise.
     */
    public function hasState(string $state): bool
    {
        return in_array($state, $this->states, true);
    }

    private function assertName(string $value, string $label): void
    {
        if ($value === '' || preg_match('/[\s\p{Z}\p{C}]/u', $value) !== 0) {
            throw new InvalidArgumentException(
                Message::VALUE_MUST_BE_NON_EMPTY_WITHOUT_WHITESPACE->getMessage($label),
            );
        }
    }

    private function assertOptionalName(string|null $value, string $label): void
    {
        if ($value !== null) {
            $this->assertName($value, $label);
        }
    }
}
