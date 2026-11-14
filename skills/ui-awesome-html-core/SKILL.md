---
name: ui-awesome-html-core
description: Use when working with HTML base elements and application-scoped configuration in ui-awesome/html-core PHP applications.
license: BSD-3-Clause
---

# Work with HTML base elements and application-scoped configuration

## Resolve the actual package

Inspect the installed package path, reference and PHP constraint before choosing an API. This checkout currently requires
PHP ^8.3. Compare Composer installed metadata, the lockfile and actual source; modified/path repositories
may differ from a published revision. A skill installation does not install runtime dependencies.

Start with `src/Config/Config.php` and only the related source, tests and guide needed for the task. Guides may be excluded from
Composer archives: use the installed source or matching-revision repository documentation, not an assumed latest API.
Do not use this package as a substitute for unrelated Yii widgets, database models or frontend asset management.

## Package-specific workflow

- Use `Html` for lower-level rendering and inspect encoding flags explicitly; low-level helpers do not share every default of fluent element `content()`.

- For custom elements choose `BaseBlock`, `BaseInline`, `BaseInput` or `BaseVoid` according to the actual rendering contract. `BaseTag::tag()` applies defaults and `render()` owns lifecycle behavior.

- Pass an application-scoped `Config` with a `ThemeInterface`; `ComponentContext` selects semantic recipes. Recipes are applied in declaration order. `Config::create()` requires a factory and throws when absent.

- Inspect `Call`, `Cookbook`, `Recipe` and `ConfigApplier` before writing payloads. Strict mode checks available methods and returned types; do not disable it merely to hide incompatible recipes.

- Use `BaseTag::tag()` with defaults resolved by `SimpleFactory::configure()`, then apply application recipes through `config()`. Keep `render()` lifecycle overrides in the `HasBeforeRun` and `HasAfterRun` hooks; `render()` itself is final.

## Intended contracts that look like bugs

Do not "fix" these; they are documented behavior covered by tests.

- With `strict: false`, `ConfigApplier` silently skips a call whose method is missing, non-public or static, and ignores a call that returns an incompatible value, keeping the previous component. An exception thrown by the invoked method is still wrapped in `ConfigException` in both modes.
- `SimpleFactory::configure()` throws `ConfigException` for numeric keys, unknown keys, non-public or static members, methods that do not return an instance of the tag class and property writes rejected at runtime. Keys resolve to methods before properties.
- `ComponentContext` normalizes string-backed enums to their backing values and rejects int-backed enums with `InvalidArgumentException`.
- `BaseBlock::end()` is static and closes the most recent `begin()` of the same class in the current Fiber or main context; it throws `LogicException` without a matching `begin()`. Begin/end state does not leak across clones or Fibers.
- `beforeRun()` returning `false` makes `render()` return an empty string instead of throwing.
- Block elements implement `ClearableContentInterface`; clearing content returns a new instance and leaves the original unchanged.

Out of scope: the attribute and content mixins (`HasAttributes`, `HasContent` and similar), which belong to `ui-awesome/html-mixin`; assert exception types rather than the exact `Exception\Message` wording.

## Verify the result

Execute focused examples against the inspected package and its actual dependencies. Assert normal, boundary and negative
cases with explicit failures; do not rely on disabled PHP assertions. Preserve supported PHP versions and report missing
runtime/tooling rather than changing constraints to manufacture a pass. Distinguish syntax, behavior, native skill
activation, browser integration and published distribution. Do not install dependencies or modify unrelated files without
an authorized task. Use the public AI assistance guide for example prompts; maintainer evidence stays private.
