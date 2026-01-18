<?php
declare(strict_types = 1);

use Innmind\Mutable\Queue;
use Innmind\BlackBox\Set;

return static function() {
    yield proof(
        'Queue',
        given(
            Set::sequence(Set::type()),
        ),
        static function($assert, $values) {
            $queue = Queue::of();

            $assert->same(0, $queue->size());
            $assert->true($queue->empty());

            foreach ($values as $i => $value) {
                $queue->push($value);

                $assert->false($queue->empty());
                $assert->same($i + 1, $queue->size());
            }

            $pulled = [];
            $size = $queue->size();

            foreach ($values as $i => $_) {
                $pulled[] = $queue->pull()->match(
                    static fn($value) => $value,
                    static fn() => null,
                );

                $assert->same($size - 1, $queue->size());
                $size = $queue->size();
            }

            $assert->true($queue->empty());
            $assert->same($values, $pulled);
        },
    );
};
