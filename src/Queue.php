<?php
declare(strict_types = 1);

namespace Innmind\Mutable;

use Innmind\Immutable\{
    Sequence,
    Maybe,
};

/**
 * @template T
 */
final class Queue
{
    /**
     * @param Sequence<T> $data
     */
    private function __construct(
        private Sequence $data,
    ) {
    }

    /**
     * @template A
     * @no-named-arguments
     *
     * @param A ...$values
     *
     * @return self<A>
     */
    public static function of(mixed ...$values): self
    {
        return new self(Sequence::of(...$values));
    }

    /**
     * @param T $element
     */
    public function push(mixed $element): void
    {
        $this->data = ($this->data)($element);
    }

    /**
     * @return Maybe<T>
     */
    #[\NoDiscard]
    public function pull(): Maybe
    {
        $value = $this->data->first();
        $this->data = $this->data->drop(1);

        return $value;
    }

    /**
     * @return int<0, max>
     */
    #[\NoDiscard]
    public function size(): int
    {
        return $this->data->size();
    }

    #[\NoDiscard]
    public function empty(): bool
    {
        return $this->data->empty();
    }

    /**
     * Remove all elements from the queue
     */
    public function clear(): void
    {
        $this->data = $this->data->clear();
    }
}
