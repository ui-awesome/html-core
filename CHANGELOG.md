# ChangeLog

## 0.3.0 Under development

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
- Enh #23: Add `HasAria` trait with `aria()` method and tests (@terabytesoftw)
- Bug #24: Improve `HasData` trait to support closure evaluation for `data-*` attributes (@terabytesoftw)
- Bug #25: Remove redundant test cases for multiple string `aria-*` attributes in `AriaProvider` class (@terabytesoftw)

## 0.2.0 December 18, 2025

- Enh #5: Refactor codebase to improve performance (@terabytesoftw)

## 0.1.0 March 30, 2024

- Enh #1: Initial commit (@terabytesoftw)
- Bug #2: Update docs `Block.md` (@terabytesoftw)
- Enh #3: Update `ui-awesome/html-attribute`, `ui-awesome/html-concern`, `ui-awesome/html-helper` to `0.2` (@terabytesoftw)
- Bug #4: Refactor `AbstractBlockElement` and `Block` classes to use `HasTagName` trait (@terabytesoftw)
