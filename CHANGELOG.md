# ChangeLog

## 0.5.3 Under development

- Dep #57: Update `ui-awesome/html-interop` requirement from `^0.2` to `^0.3` in `composer.json` (@terabytesoftw)
- Enh #58: Add `loadDefault()` method in `BaseTag` class to provide default attribute values (@terabytesoftw)
- Bug #59: Update PHP version requirement in `BaseTagTest` from `8.4` to `8.5` (@terabytesoftw)

## 0.5.2 January 28, 2026

- Bug #53: Add section for automated refactoring using `Rector` in testing documentation (@terabytesoftw)
- Bug #54: Update examples in `testing.md` for running Composer script with arguments and update `.styleci.yml` accordingly (@terabytesoftw)
- Bug #55: Update command syntax in `development.md` and `testing.md` for clarity and consistency (@terabytesoftw)
- Bug #56: Remove redundant ignore rule in `actionlint.yml` configuration and update Rector command in `composer.json` to remove unnecessary 'src' argument (@terabytesoftw)

## 0.5.1 January 24, 2026

- Enh #52: Add `php-forge/coding-standard` to development dependencies for code quality checks (@terabytesoftw)

## 0.5.0 January 19, 2026

- Enh #42: Introduce interfaces for block, inline, and void tags; update related classes and tests (@terabytesoftw)
- Bug #43: Update usage examples for `getTag()` method in `BaseBlock`, `BaseInline`, and `BaseVoid` classes (@terabytesoftw)
- Enh #44: Using global config files organization (@terabytesoftw)
- Enh #45: Move related tag classes to `ui-awesome/html-interop` package and update imports accordingly (@terabytesoftw)
- Enh #46: Add development guide and sync metadata instructions and update testing documentation (@terabytesoftw)
- Enh #47: Use package `ui-awesome/html-mixin` for mixin traits and update related imports accordingly (@terabytesoftw)
- Enh #48: Move attribute traits from `ui-awesome/html-core` package and update related imports accordingly (@terabytesoftw)
- Bug #49: Update documentation for clarity and consistency (@terabytesoftw)
- Bug #50: Improve `testing.md` for clarity and consistency in Composer script usage (@terabytesoftw)
- Bug #51: Update documentation in tests for clarity and consistency (@terabytesoftw)

## 0.4.0 December 27, 2025

- Bug #37: Move `Message` enum to `Helper\Exception` namespace and clean up unused cases (@terabytesoftw)
- Bug #38: Update method calls to use `getAttributes()` method for consistency in `BaseBlock`, `BaseInline`, and `BaseVoid` classes (@terabytesoftw)
- Bug #39: Rename exception test methods for clarity and consistency (@terabytesoftw)
- Bug #40: Consolidate attribute handling in `setAttribute()` method in `HasAttributes` class and remove redundant code in related classes (@terabytesoftw)
- Dep #41: Update `ui-awesome/html-helper` version constraint to `^0.6` in `composer.json` and adjust related tests (@terabytesoftw)

## 0.3.1 December 26, 2025

- Bug #33: Update test group annotations for `BaseTagTest` and `SimpleFactoryTest` classes (@terabytesoftw)
- Dep #34: Update `infection/infection` version constraint to `^0.32` in `composer.json` (@terabytesoftw)
- Enh #35: Add `SVG` case to `Block` enum for HTML tag representation (@terabytesoftw)
- Bug #36: Simplify attribute management by utilizing `addAttribute` method across multiple traits (@terabytesoftw)

## 0.3.0 December 24, 2025

- Bug #6: Update testsuite name to match project name (@terabytesoftw)
- Enh #7: Add methods to set and remove single HTML attributes (@terabytesoftw)
- Enh #8: Enhance data attribute handling with support for `scalar`, `Closure`, and `UnitEnum` values (@terabytesoftw)
- Bug #9: Update `dataAttribute()` method handling to support enum values and improve error messages (@terabytesoftw)
- Bug #10: Update documentation for `dataAttributes()` method to include example with enum value (@terabytesoftw)
- Bug #11: Enhance `DataProvider` class documentation and add comprehensive test cases for HTML `data-*` attributes (@terabytesoftw)
- Bug #12: Update `removeDataAttribute()` method documentation to include example with enum key (@terabytesoftw)
- Bug #13: Correct documentation formatting for key features across multiple attribute and providers external classes (@terabytesoftw)
- Enh #14: Enhance `addAttribute()` and `removeAttribute()` methods to support enum keys and improve handling of attributes (@terabytesoftw)
- Bug #15: Update PHPStan annotations in `DataProvider` and `HasDataTest` classes for improved type clarity (@terabytesoftw)
- Enh #16: Enhance support for `Stringable` interface types across `HasClass`, `HasData`, `HasStyle`, `HasTitle` and update related tests (@terabytesoftw)
- Bug #17: Add cases for `<details>`, `<dialog>`, and `<menu>` HTML tags in `Block` enum (@terabytesoftw)
- Enh #18: Add `HasAccesskey` trait with `accesskey()` method and tests (@terabytesoftw)
- Enh #19: Add `HasTranslate` trait with `translate()` method and tests (@terabytesoftw)
- Bug #20: Update `draggable` method parameter type to include `UnitEnum` class (@terabytesoftw)
- Bug #21: Improve PHPDoc for attribute related classes to reflect support for `UnitEnum` types (@terabytesoftw)
- Enh #22: Add `HasRole` trait with `role()` method and tests (@terabytesoftw)
- Enh #23: Add `HasAria` trait with `ariaAttributes()`, `addAriaAttribute()`, `removeAriaAttribute()` methods and tests (@terabytesoftw)
- Bug #24: Improve `HasData` trait to support closure evaluation for `data-*` attributes (@terabytesoftw)
- Bug #25: Remove redundant test cases for multiple string `aria-*` attributes in `AriaProvider` class (@terabytesoftw)
- Enh #26: Add `AttributeProperty` enum to standardize common HTML attribute names (@terabytesoftw)
- Bug #27: Update `style()` method to accept array as a valid input type in `HasStyle` trait (@terabytesoftw)
- Bug #28: Improve `HasAriaTest` and `AriaProvider` with comprehensive test coverage for `aria-*` attributes (@terabytesoftw)
- Enh #29: Add `HasEvents` trait with `events()`, `addEvent()`, `removeEvent()` methods and tests (@terabytesoftw)
- Bug #30: Improve `HasAriaTest` with additional test cases for invalid `aria-*` attribute keys and `AriaProvider` data provider (@terabytesoftw)
- Bug #31: Improve `HasEventsTest` with additional cases for invalid `on-*` attribute keys and `EventProvider` data provider (@terabytesoftw)
- Bug #32: Refactor `HasAria`, `HasData` and `HasEvents` classes for handling normalize keys and update related tests (@terabytesoftw)

## 0.2.0 December 18, 2025

- Enh #5: Refactor codebase to improve performance (@terabytesoftw)

## 0.1.0 March 30, 2024

- Enh #1: Initial commit (@terabytesoftw)
- Bug #2: Update docs `Block.md` (@terabytesoftw)
- Dep #3: Update `ui-awesome/html-attribute`, `ui-awesome/html-concern`, `ui-awesome/html-helper` to `0.2` in `composer.json` (@terabytesoftw)
- Bug #4: Refactor `AbstractBlockElement` and `Block` classes to use `HasTagName` trait (@terabytesoftw)
