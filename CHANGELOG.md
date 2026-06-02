# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Conventional Commits](https://www.conventionalcommits.org/en/v1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## 0.6.1 Under development

- chore: migrate to `yii2-extensions/scaffold` consumer model with `php-forge/baseline` and `php-forge/coding-standard ^0.3@dev`.
- chore: update dependencies and configuration files.
- docs: Correct image source order in `README.md` for feature overview.
- docs: add Facebook follow badge to `README.md`.

## 0.6.0 May 1, 2026

- chore: update the `ui-awesome/html-interop` requirement from `^0.2` to `^0.3`.
- feat: add `BaseTag::loadDefault()` for class-level default configuration.
- fix: update the PHP version requirement in `BaseTagTest` from `8.4` to `8.5`.
- feat: add `BaseInput` for input elements and improve prefix/suffix rendering for block, inline, and void tags.
- fix: correct parameter order in `BaseInput` and `BaseInline` docblocks.
- fix: reorder `BaseInput` imports.
- feat: use `HasName` in `BaseInput` for the `name` attribute.
- test: add token-value stubs for `TagInline` and `TagInput` template rendering.
- fix: use prefix and suffix getters in `BaseInput` and `BaseInline`.
- fix: improve HTML output formatting with `PHP_EOL` line breaks in core renderers.
- docs: standardize PHPDoc headers for source and test classes.
- fix: add `BaseBlock::afterRun()` to normalize excessive line breaks.
- chore: update `ui-awesome/html-helper` to `^0.7` and `ui-awesome/html-mixin` to `^0.4`.
- docs: remove usage examples from PHPDoc in multiple classes.
- docs: update last-modified references from `ui-awesome/html-attribute` in related classes.
- feat: align base elements with `ui-awesome/html-contracts` and migrate tag type hints to `BackedEnum`.
- fix: remove automatic `aria-describedby` handling and suffix customization from `BaseInput`.
- docs: refresh feature overview SVGs with the shared documentation layout and alphabetical ordering.
- chore: prepare the `0.6.0` release with workflow, docs, input element, and test updates.

## 0.5.2 January 28, 2026

- docs: add an automated refactoring section to the testing documentation.
- docs: update testing examples for running Composer scripts with arguments.
- docs: update command syntax in `development.md` and `testing.md` for clarity and consistency.
- chore: remove the redundant ignore rule in `actionlint.yml` and update the Rector command.

## 0.5.1 January 24, 2026

- chore: add `php-forge/coding-standard` to development dependencies for code quality checks.

## 0.5.0 January 19, 2026

- feat: introduce interfaces for block, inline, and void tags.
- docs: update `getTag()` usage examples in `BaseBlock`, `BaseInline`, and `BaseVoid`.
- chore: use global configuration file organization.
- feat: move related tag classes to `ui-awesome/html-interop` and update imports.
- docs: add a development guide and sync metadata instructions.
- chore: use `ui-awesome/html-mixin` for mixin traits and update imports.
- refactor: move attribute traits from `ui-awesome/html-core` and update imports.
- docs: update documentation for clarity and consistency.
- docs: improve `testing.md` Composer script usage.
- docs: update test documentation for clarity and consistency.

## 0.4.0 December 27, 2025

- refactor: move the `Message` enum to the `Helper\Exception` namespace and remove unused cases.
- fix: use `getAttributes()` consistently in `BaseBlock`, `BaseInline`, and `BaseVoid`.
- test: rename exception test methods for clarity and consistency.
- refactor: consolidate attribute handling through `setAttribute()` and remove redundant code.
- chore: update the `ui-awesome/html-helper` requirement to `^0.6` and adjust related tests.

## 0.3.1 December 26, 2025

- test: update group annotations for `BaseTagTest` and `SimpleFactoryTest`.
- chore: update the `infection/infection` version constraint to `^0.32`.
- feat: add the `SVG` case to the block tag enum.
- refactor: simplify attribute management by using `addAttribute()` across traits.

## 0.3.0 December 24, 2025

- test: update the test suite name to match the project name.
- feat: add methods to set and remove single HTML attributes.
- feat: enhance data attribute handling with scalar, closure, and `UnitEnum` values.
- fix: support enum values in `dataAttribute()` and improve error messages.
- docs: update `dataAttributes()` documentation with an enum value example.
- test: enhance data provider documentation and add comprehensive HTML `data-*` attribute cases.
- docs: update `removeDataAttribute()` documentation with an enum key example.
- docs: correct feature documentation formatting across attribute and provider classes.
- feat: support enum keys in `addAttribute()` and `removeAttribute()`.
- docs: update PHPStan annotations in data providers and data attribute tests.
- feat: add `Stringable` support across class, data, style, and title attribute traits.
- feat: add `<details>`, `<dialog>`, and `<menu>` cases to the block tag enum.
- feat: add `HasAccesskey` with `accesskey()` and tests.
- feat: add `HasTranslate` with `translate()` and tests.
- fix: allow `UnitEnum` values in the `draggable()` parameter type.
- docs: improve attribute PHPDoc to reflect `UnitEnum` support.
- feat: add `HasRole` with `role()` and tests.
- feat: add `HasAria` with ARIA attribute collection methods and tests.
- fix: support closure evaluation in `HasData` for `data-*` attributes.
- test: remove redundant string `aria-*` cases from the ARIA provider.
- feat: add `AttributeProperty` for common HTML attribute names.
- fix: allow arrays as valid input for `style()`.
- test: improve ARIA attribute test coverage.
- feat: add `HasEvents` with event attribute collection methods and tests.
- test: add invalid ARIA attribute key cases.
- test: add invalid event attribute key cases.
- refactor: improve key normalization in ARIA, data, and event attribute traits.

## 0.2.0 December 18, 2025

- refactor: improve codebase performance.

## 0.1.0 March 30, 2024

- feat: initial `ui-awesome/html-core` package structure.
- docs: update block documentation.
- chore: update `ui-awesome/html-attribute`, `ui-awesome/html-concern`, and `ui-awesome/html-helper` to `0.2`.
- refactor: use `HasTagName` in abstract block element and block classes.
