# RUNTIME PACKAGE GUIDE

## OVERVIEW

The bundle turns normalized `knp_dictionary` configuration into tagged dictionary services, aggregates them in a public collection, and exposes that collection through Symfony adapters.

## STRUCTURE

```text
DictionaryBundle/
├── DependencyInjection/  # Config tree, extension, compiler passes
├── Dictionary/           # Core contracts, implementations, factories
├── Resources/            # Service fragments and profiler template
├── ValueTransformer/     # Ordered value transformation aggregate
└── {Form,Validator,Templating,Faker,DataCollector}/ # Thin adapters
```

## RUNTIME FLOW

```text
knp_dictionary config
  -> KnpDictionaryExtension
  -> knp_dictionary.configuration parameter
  -> DictionaryBuildingPass
  -> Factory\Aggregate::create()
  -> tagged Dictionary service
  -> DictionaryRegistrationPass
  -> Dictionary\Collection
  -> framework adapters
```

`services/debug.yaml` always defines the collector; the final pass therefore decorates every tagged dictionary with `Traceable` in the normal bundle load path.

## WHERE TO LOOK

| Change | Files that move together |
|--------|--------------------------|
| Add a config key | `DependencyInjection/Configuration.php`, consuming factory/pass, matching specs |
| Add a built-in dictionary type | Factory implementation, `Resources/config/services/factories.yaml`, configuration schema, specs |
| Add a framework adapter | Adapter class, dedicated service YAML fragment, import in `services.yaml`, mirrored spec |
| Change registration | `KnpDictionaryExtension.php`, compiler pass constants/processors, bundle pass order |
| Change profiler behavior | `DictionaryTracePass`, `Dictionary/Traceable.php`, collector, Twig layout |

## CONVENTIONS

- `KnpDictionaryExtension` autoconfigures implementations of `Dictionary` and `Dictionary\Factory`; manual tags are `knp_dictionary.dictionary` and `knp_dictionary.factory`.
- Compiler pass order is build dictionaries, collect factories, register dictionaries, then add trace decorators.
- `Configuration` normalizes bare maps and `content`-only entries to `type: value`; `normalizeKeys(false)` preserves dictionary keys.
- Generated definitions defer construction to `Factory\Aggregate::create()` through a container factory reference.
- Registration and tracing deliberately discover the same dictionary tag; tracing runs after collection method calls are recorded.

## ANTI-PATTERNS

- Do not add accepted factory input only in `supports()` or `create()`; the configuration tree rejects unknown keys first.
- Do not replace generated definitions with compiler-time instances; container references preserve service lookup and lazy sources.
- Do not remove dictionary tags after building; both collection registration and profiler decoration depend on them.
- Do not make optional adapters public merely to retrieve them from the container; their framework tags are the integration API.
