<?php

namespace gamboamartin\gastos\models;

class Stream {
    private $elements;

    private function __construct(array $elements) {
        $this->elements = $elements;
    }

    public static function of(array $elements): Stream
    {
        return new Stream($elements);
    }

    public function filter(callable $predicate): Stream
    {
        $filtered = array_filter($this->elements, $predicate);
        return new Stream(array_values($filtered));
    }

    public function map(callable $mapper): Stream
    {
        $mapped = array_map($mapper, $this->elements);
        return new Stream($mapped);
    }

    public function reduce(callable $reducer, $initial = null) {
        return array_reduce($this->elements, $reducer, $initial);
    }

    public function toArray(): array
    {
        return $this->elements;
    }

    public function forEach(callable $action): void
    {
        foreach ($this->elements as $element) {
            $action($element);
        }
    }

    public function findFirst() {
        return isset($this->elements[0]) ? $this->elements[0] : null;
    }

    public function distinct() {
        $unique = array_unique($this->elements);
        return new Stream(array_values($unique));
    }

    public function flatMap(callable $mapper) {
        $flattened = [];
        foreach ($this->elements as $element) {
            $result = $mapper($element);
            if (is_array($result)) {
                $flattened = array_merge($flattened, $result);
            } else {
                $flattened[] = $result;
            }
        }
        return new Stream($flattened);
    }
}

