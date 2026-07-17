# PHPSPEC GUIDE

## OVERVIEW

Behavior suite mirroring the runtime namespace with source-aligned specifications.

## STRUCTURE

```text
spec/
├── Knp/DictionaryBundle/ # Source-mirrored ObjectBehavior specs
└── PHPSpec/              # Local extension and shouldBeOneOf matcher
```

## WHERE TO LOOK

| Task | Location | Notes |
|------|----------|-------|
| Domain/factory behavior | `Knp/DictionaryBundle/Dictionary/` | Largest coverage area; inline data and helper callables/iterators |
| Compiler wiring | `Knp/DictionaryBundle/DependencyInjection/Compiler/` | Assert definitions, tags, arguments, and method calls exactly |
| Shared matcher | `PHPSpec/OneOfMatcher.php` | Strict membership matcher used by Faker specs |
| Extension registration | `PHPSpec/Extension.php` | Loaded by both PHPSpec config files |

## CONVENTIONS

- Mirror the source path and name classes `final class FooSpec extends ObjectBehavior`.
- Name examples `it_*`/`its_*`; use `let()` for common setup and constructor injection.
- Use Prophecy collaborators for interfaces; pass wrapped collaborators into real `Collection` instances when collection behavior matters.
- Keep fixtures inline; the suite has no fixture, mock, or data directories.
- Test both `supports()` dispatch and `create()` output/error behavior for factories.

## COMMANDS

```bash
vendor/bin/phpspec run
vendor/bin/phpspec run spec/Knp/DictionaryBundle/Dictionary/SimpleSpec.php
```

The default config writes `coverage.xml`; use the parent guide's no-coverage command for routine full-suite checks.

## GAPS TO REMEMBER

- `DictionaryTracePass::process()` has no direct spec; bundle registration alone is covered.
- `KnpDictionaryExtensionSpec` only checks initialization, not service/config loading behavior.
- Interfaces and `Dictionary\Wrapper` lack direct specs and are exercised through implementations.
