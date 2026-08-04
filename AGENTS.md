# PROJECT KNOWLEDGE BASE

## OVERVIEW

Reusable Symfony bundle for declaring named dictionaries in application configuration and consuming them through DI, forms, validation, Twig, Faker, and the web profiler. Treat `composer.json` and the CI matrix as the sources of truth for supported runtime and framework versions.

## STRUCTURE

```text
DictionaryBundle/
├── src/Knp/DictionaryBundle/   # PSR-4 runtime package; legacy nested bundle layout
├── spec/Knp/DictionaryBundle/  # PHPSpec tree mirroring runtime namespaces
├── spec/PHPSpec/               # Local extension and shouldBeOneOf matcher
├── bin/lint-twig               # Standalone Twig syntax check
└── .github/workflows/test.yaml # Compatibility matrix and quality gates
```

## WHERE TO LOOK

| Task | Location | Notes |
|------|----------|-------|
| Bundle bootstrap | `src/Knp/DictionaryBundle/KnpDictionaryBundle.php` | Registers compiler passes in significant order |
| User configuration | `src/Knp/DictionaryBundle/DependencyInjection/Configuration.php` | Normalizes `knp_dictionary.dictionaries` |
| Service composition | `src/Knp/DictionaryBundle/Resources/config/services.yaml` | Imports explicit service fragments |
| Dictionary behavior | `src/Knp/DictionaryBundle/Dictionary/` | Implementations, collection, wrappers, factories |
| Framework adapters | `Form/`, `Validator/`, `Templating/`, `Faker/`, `DataCollector/` | All consume the shared collection |
| Behavioral specs | `spec/Knp/DictionaryBundle/` | Mirrors source paths |

## CONVENTIONS

- Runtime namespace maps to `src/Knp/DictionaryBundle`; specs map `spec\Knp\` to `spec/Knp`.
- PHP files use strict types, final concrete classes, and ordered imports/interfaces.
- DI YAML uses explicit FQCN service IDs, arguments, and tags. No broad autowire/autoconfigure resource block.
- Services are private except public API entry points: `Dictionary\Collection` and the `Dictionary\Factory` alias.
- Behavior changes require a matching PHPSpec example; specs keep data inline and use Prophecy collaborators.

## ANTI-PATTERNS (THIS PROJECT)

- Do not eagerly evaluate callable or iterator-backed dictionaries. Their documented contract is lazy until first value access.
- Before relying on a documented DI tag, verify that a compiler pass or autoconfiguration actually consumes it.
- Do not reorder compiler passes or tagged factory definitions without tracing construction order and running the relevant specs.
- Use the configured quality-tool commands below as the source of truth when prose documentation differs.

## COMMANDS

```bash
composer install
vendor/bin/phpspec run -v --config=phpspec.no-coverage.yml
vendor/bin/phpstan analyse --no-progress --memory-limit=-1
bin/lint-twig src/
PHP_CS_FIXER_IGNORE_ENV=1 vendor/bin/php-cs-fixer fix --diff --dry-run -vvv
vendor/bin/rector process --dry-run
```

## NOTES

- CI derives compatibility constraints at runtime to test both dependency floors and current releases; do not rely on a single local dependency set.
- Tool configuration files define analysis levels and paths; do not duplicate those values here.
- Keep runtime versions and temporary compatibility status out of this document. Declare them in `composer.json` and encode them in the CI matrix, with short inline comments for intentional exclusions.
