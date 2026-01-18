<?php
declare(strict_types = 1);

namespace Innmind\Mutable;

use Innmind\{
    Immutable,
    Immutable\Maybe,
};

/**
 * @template K
 * @template V
 */
final class Map
{
    /**
     * @psalm-mutation-free
     *
     * @param Immutable\Map<K, V> $map
     */
    private function __construct(
        private Immutable\Map $map,
    ) {
    }

    /**
     * Set a new key/value pair
     *
     * @param K $key
     * @param V $value
     */
    public function __invoke(mixed $key, mixed $value): void
    {
        $this->map = ($this->map)($key, $value);
    }

    /**
     * @template A
     * @template B
     * @no-named-arguments
     * @psalm-pure
     *
     * @param list<array{A, B}> $pairs
     *
     * @return self<A, B>
     */
    public static function of(array ...$pairs): self
    {
        return new self(Immutable\Map::of(...$pairs));
    }

    /**
     * @return int<0, max>
     */
    #[\NoDiscard]
    public function size(): int
    {
        return $this->map->size();
    }

    /**
     * Set a new key/value pair
     *
     * @param K $key
     * @param V $value
     */
    public function put(mixed $key, mixed $value): void
    {
        $this->map = ($this->map)($key, $value);
    }

    /**
     * Return the element with the given key
     *
     * @param K $key
     *
     * @return Maybe<V>
     */
    #[\NoDiscard]
    public function get(mixed $key): Maybe
    {
        return $this->map->get($key);
    }

    /**
     * Check if there is an element for the given key
     *
     * @param K $key
     */
    #[\NoDiscard]
    public function contains(mixed $key): bool
    {
        return $this->map->contains($key);
    }

    /**
     * Remove all elements from the map
     */
    public function clear(): void
    {
        $this->map = $this->map->clear();
    }

    /**
     * Remove all elements that don't match the predicate
     *
     * @param callable(K, V): bool $predicate
     */
    public function filter(callable $predicate): void
    {
        $this->map = $this->map->filter($predicate);
    }

    /**
     * Remove all elements that match the predicate
     *
     * @param callable(K, V): bool $predicate
     */
    public function exclude(callable $predicate): void
    {
        $this->map = $this->map->exclude($predicate);
    }

    /**
     * Run the given function for each element of the map
     *
     * @param callable(K, V): void $function
     */
    public function foreach(callable $function): void
    {
        $_ = $this->map->foreach($function);
    }

    /**
     * Remove the element with the given key
     *
     * @param K $key
     */
    public function remove(mixed $key): void
    {
        $this->map = $this->map->remove($key);
    }

    #[\NoDiscard]
    public function empty(): bool
    {
        return $this->map->empty();
    }

    /**
     * @return Immutable\Map<K, V>
     */
    #[\NoDiscard]
    public function snapshot(): Immutable\Map
    {
        return $this->map;
    }
}
