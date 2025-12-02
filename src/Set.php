<?php
declare(strict_types = 1);

namespace Innmind\Mutable;

use Innmind\Immutable;

/**
 * @template T
 */
final class Set
{
    /**
     * @param Immutable\Set<T> $set
     */
    private function __construct(
        private Immutable\Set $set,
    ) {
    }

    /**
     * Add an element to the set
     *
     * @param T $element
     */
    public function __invoke(mixed $element): void
    {
        $this->set = ($this->set)($element);
    }

    /**
     * @template A
     * @no-named-arguments
     *
     * @param A $values
     *
     * @return self<A>
     */
    public static function of(mixed ...$values): self
    {
        return new self(Immutable\Set::of(...$values));
    }

    /**
     * @return int<0, max>
     */
    #[\NoDiscard]
    public function size(): int
    {
        return $this->set->size();
    }

    /**
     * Add an element to the set
     *
     * @param T $element
     */
    public function add(mixed $element): void
    {
        $this->set = ($this->set)($element);
    }

    /**
     * Check if the set contains the given element
     *
     * @param T $element
     */
    #[\NoDiscard]
    public function contains(mixed $element): bool
    {
        return $this->set->contains($element);
    }

    /**
     * Remove the element from the set
     *
     * @param T $element
     */
    public function remove(mixed $element): void
    {
        $this->set = $this->set->remove($element);
    }

    /**
     * Remove all elements that don't satisfy the given predicate
     *
     * @param callable(T): bool $predicate
     */
    public function filter(callable $predicate): void
    {
        $this->set = $this->set->filter($predicate);
    }

    /**
     * Remove all elements that satisfy the given predicate
     *
     * @param callable(T): bool $predicate
     */
    public function exclude(callable $predicate): void
    {
        $this->set = $this->set->exclude($predicate);
    }

    /**
     * Apply the given function to all elements of the set
     *
     * @param callable(T): void $function
     */
    public function foreach(callable $function): void
    {
        $_ = $this->set->foreach($function);
    }

    /**
     * Removes all elements from the set
     */
    public function clear(): void
    {
        $this->set = $this->set->clear();
    }

    #[\NoDiscard]
    public function empty(): bool
    {
        return $this->set->empty();
    }
}
