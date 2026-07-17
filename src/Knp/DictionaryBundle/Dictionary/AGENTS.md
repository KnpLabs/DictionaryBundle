# DICTIONARY DOMAIN GUIDE

## OVERVIEW

Core dictionary contracts, eager and lazy implementations, the name-indexed collection, decorators, and the ordered factory chain.

## WHERE TO LOOK

| Concern | Location | Constraint |
|---------|----------|------------|
| Public value contract | `../Dictionary.php` | ArrayAccess + Countable + IteratorAggregate + name/keys/values |
| Registry | `Collection.php` | Add through `add()`; ArrayAccess mutation is rejected |
| Basic storage | `Simple.php` | Backing implementation for value-based factories |
| Lazy callable/iterator | `Invokable.php`, `Iterator.php` | Source must remain untouched until first data access |
| Composition | `Combined.php`, `Factory/Combined.php` | Resolves referenced names through Collection |
| Inheritance | `Factory/Extended.php` | Base dictionary precedes new values in merge order |
| Debug decoration | `Traceable.php` | Delegates behavior and records collector access |
| Factory dispatch | `Factory.php`, `Factory/Aggregate.php` | First factory whose `supports()` returns true wins |

## FACTORY ORDER

`../Resources/config/services/factories.yaml` declares `Extended` before type factories because any config containing `extends` must be intercepted first. `../DependencyInjection/Compiler/DictionaryFactoryBuildingPass.php` preserves tagged-service discovery order when calling `Aggregate::addFactory()`.

Built-in factory triggers are:

- `value`, `value_as_key`, `key_value`: content-backed dictionaries with value transformation.
- `callable`: container service plus optional method, wrapped lazily by `Dictionary\Invokable`.
- `iterator`: Traversable container service, wrapped lazily by `Dictionary\Iterator`.
- `combined`: ordered names resolved from `Collection`.
- `extends`: wrapper factory applied before the underlying type factory.

## CONVENTIONS

- Each concrete factory validates its required config at `create()` and keeps `supports()` limited to dispatch.
- `Combined` and `Extended` resolve dependencies by dictionary name; declaration order matters because referenced dictionaries must already exist when instantiated.
- Preserve generic PHPDoc on `Dictionary<E>`, implementations, collections, and factory return types; PHPStan runs at level 8.
- Mirror behavior changes under `spec/Knp/DictionaryBundle/Dictionary`, including factory `supports()` cases and invalid configuration.

## ANTI-PATTERNS

- Do not reorder factories casually; overlapping `supports()` predicates change which implementation is constructed.
- Do not call or traverse lazy sources in constructors, factory validation, or `getName()`.
- Do not mutate `Collection` through array offsets; use `add()` so names remain the sole keys.
- Do not silently reverse merge precedence for extended or combined dictionaries.
