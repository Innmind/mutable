<?php
declare(strict_types = 1);

use Innmind\Mutable\Ring;
use Innmind\BlackBox\Set;

return static function() {
    yield proof(
        'Ring',
        given(
            Set::sequence(Set::type())->atLeast(1),
            Set::integers()->between(1, 10),
        ),
        static function($assert, $values, $rotations) {
            $ring = Ring::of(...$values);
            $pulled = [];

            foreach (\range(1, $rotations) as $_) {
                foreach (\range(1, \count($values)) as $__) {
                    $pulled[] = $ring->pull()->match(
                        static fn($value) => $value,
                        static fn() => null,
                    );
                }
            }

            $expected = \array_merge(
                ...\array_fill(
                    0,
                    $rotations,
                    $values,
                ),
            );

            $assert->same($expected, $pulled);
        },
    );

    yield proof(
        'Partial Ring rotations',
        given(
            Set::sequence(Set::type())->atLeast(1),
            Set::integers()->between(1, 1_000),
        ),
        static function($assert, $values, $toPull) {
            $ring = Ring::of(...$values);
            $pulled = [];

            foreach (\range(1, $toPull) as $_) {
                $pulled[] = $ring->pull()->match(
                    static fn($value) => $value,
                    static fn() => null,
                );
            }

            $expected = \array_slice(
                \array_merge(
                    ...\array_fill(
                        0,
                        (int) \ceil($toPull / \count($values)),
                        $values,
                    ),
                ),
                0,
                $toPull,
            );

            $assert->same($expected, $pulled);
        },
    );

    yield test(
        'Empty Ring returns nothing',
        static fn($assert) => $assert->false(Ring::of()->pull()->match(
            static fn() => true,
            static fn() => false,
        )),
    );
};
