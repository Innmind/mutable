<?php
declare(strict_types = 1);

namespace Innmind\Mutable;

use Innmind\Immutable\Maybe;

/**
 * @template T
 */
final class Ring
{
    /**
     * @psalm-mutation-free
     *
     * @param list<T> $data
     */
    private function __construct(
        private array $data,
    ) {
    }

    /**
     * @template A
     * @no-named-arguments
     * @psalm-pure
     *
     * @param A ...$values
     *
     * @return self<A>
     */
    public static function of(mixed ...$values): self
    {
        return new self($values);
    }

    /**
     * @return Maybe<T>
     */
    public function pull(): Maybe
    {
        if (!\array_key_exists(0, $this->data)) {
            /** @var Maybe<T> */
            return Maybe::nothing();
        }

        $value = Maybe::just(\current($this->data));
        \next($this->data);

        if (\is_null(\key($this->data))) {
            \reset($this->data);
        }

        return $value;
    }

    /**
     * Move the ring cursor to the first value
     */
    public function reset(): void
    {
        \reset($this->data);
    }
}
