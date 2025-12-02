<?php
declare(strict_types = 1);

use Innmind\Mutable\Stack;
use Innmind\BlackBox\Set;

return static function() {
    yield proof(
        'Stack',
        given(
            Set::sequence(Set::type()),
        ),
        static function($assert, $values) {
            $stack = Stack::of();

            $assert->same(0, $stack->size());
            $assert->true($stack->empty());

            foreach ($values as $i => $value) {
                $stack->push($value);

                $assert->false($stack->empty());
                $assert->same($i + 1, $stack->size());
            }

            $pulled = [];
            $size = $stack->size();

            foreach ($values as $i => $_) {
                $pulled[] = $stack->pull()->match(
                    static fn($value) => $value,
                    static fn() => null,
                );

                $assert->same($size - 1, $stack->size());
                $size = $stack->size();
            }

            $assert->true($stack->empty());
            $assert->same(\array_reverse($values), $pulled);
        },
    );
};
