<?php

declare(strict_types=1);

namespace UIAwesome\Html\Core\Config;

use BackedEnum;
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
 * The component identifier, qualifiers, and states accept a string or a string-backed enum. Enum cases are normalized
 * to their backing values, so the public properties and {@see ComponentContext::hasState()} always work with plain
 * strings, regardless of how the context was created.
 */
final readonly class ComponentContext
{
    /**
     * Semantic component identifier, normalized to a string.
     */
    public string $component;
    /**
     * Extensible semantic metadata available to config providers.
     *
     * Object values are stored by reference, so pass immutable values when deep immutability is required.
     *
     * @var array<string, mixed>
     */
    public array $metadata;
    /**
     * Optional color scheme, normalized to a string.
     */
    public string|null $scheme;
    /**
     * Optional component size, normalized to a string.
     */
    public string|null $size;
    /**
     * Active component states, normalized to strings.
     *
     * @var list<string>
     */
    public array $states;
    /**
     * Optional presentation variant, normalized to a string.
     */
    public string|null $variant;

    /**
     * @param BackedEnum|string $component Semantic component identifier, for example `field.control.email`.
     * @param BackedEnum|string|null $variant Optional presentation variant.
     * @param BackedEnum|string|null $size Optional component size.
     * @param BackedEnum|string|null $scheme Optional color scheme.
     * @param array<array-key, mixed> $states Active component states, as strings or string-backed enums.
     * @param array<array-key, mixed> $metadata Additional semantic metadata.
     *
     * @throws InvalidArgumentException If the component identifier, a qualifier, or a state is an int-backed enum, is
     * empty, or contains whitespace, the states are not a list of strings or backed enums, or a metadata key is not a
     * non-empty string.
     */
    public function __construct(
        string|BackedEnum $component,
        string|BackedEnum|null $variant = null,
        string|BackedEnum|null $size = null,
        string|BackedEnum|null $scheme = null,
        array $states = [],
        array $metadata = [],
    ) {
        $this->component = $this->normalizeName($component, 'Component identifier');
        $this->variant = $this->normalizeOptionalName($variant, 'Variant');
        $this->size = $this->normalizeOptionalName($size, 'Size');
        $this->scheme = $this->normalizeOptionalName($scheme, 'Scheme');

        if (array_is_list($states) === false) {
            throw new InvalidArgumentException(
                Message::COMPONENT_STATES_MUST_BE_STRING_LIST->getMessage(),
            );
        }

        $normalizedStates = [];

        foreach ($states as $state) {
            if (is_string($state) === false && $state instanceof BackedEnum === false) {
                throw new InvalidArgumentException(
                    Message::COMPONENT_STATES_MUST_BE_STRING_LIST->getMessage(),
                );
            }

            $normalizedStates[] = $this->normalizeName($state, 'Component state');
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
     * @param BackedEnum|string $state State name, or a string-backed enum whose backing value is the state name.
     *
     * @throws InvalidArgumentException If the state is an int-backed enum.
     *
     * @return bool `true` if the state is active, `false` otherwise.
     */
    public function hasState(string|BackedEnum $state): bool
    {
        return in_array($this->toName($state, 'Component state'), $this->states, true);
    }

    private function assertName(string $value, string $label): void
    {
        if ($value === '' || preg_match('/[\s\p{Z}\p{C}]/u', $value) !== 0) {
            throw new InvalidArgumentException(
                Message::VALUE_MUST_BE_NON_EMPTY_WITHOUT_WHITESPACE->getMessage($label),
            );
        }
    }

    private function normalizeName(string|BackedEnum $value, string $label): string
    {
        $name = $this->toName($value, $label);

        $this->assertName($name, $label);

        return $name;
    }

    private function normalizeOptionalName(string|BackedEnum|null $value, string $label): string|null
    {
        return $value === null ? null : $this->normalizeName($value, $label);
    }

    private function toName(string|BackedEnum $value, string $label): string
    {
        if (is_string($value)) {
            return $value;
        }

        $name = $value->value;

        if (is_string($name) === false) {
            throw new InvalidArgumentException(
                Message::VALUE_MUST_BE_STRING_OR_STRING_BACKED_ENUM->getMessage($label, $value::class),
            );
        }

        return $name;
    }
}
