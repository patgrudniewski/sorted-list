<?php

declare(strict_types=1);

namespace PatGrudniewski\SortedList;

final class SortedLinkedList implements LinkedListInterface
{
    public private(set) ?LinkedListInterface $previous = null;
    public private(set) ?LinkedListInterface $next = null;

    public function __construct(
        public readonly int $value,
    ) {
    }

    public function addItem(int $value): void
    {
        $newItem = new SortedLinkedList($value);
        [$prev, $next] = $this->match($value);

        $newItem->previous = $prev;
        $newItem->next = $next;

        if (null !== $next) {
            $next->previous = $newItem;
        }

        if (null !== $prev) {
            $prev->next = $newItem;
        }
    }

    private function matchesJustAfter(int $value): bool
    {
        return $value >= $this->value && (null === $this->next || $value <= $this->next->value);
    }

    private function matchesJustBefore(int $value): bool
    {
        return $value <= $this->value && (null === $this->previous || $value >= $this->previous->value);
    }

    /**
     * @return array{LinkedListInterface, ?LinkedListInterface} | array{?LinkedListInterface, LinkedListInterface}
     */
    private function match(int $value): array
    {
        if ($value > $this->value) {
            if ($this->matchesJustAfter($value)) {
                return [$this, $this->next];
            }

            return $this->next->match($value);
        } else {
            if ($this->matchesJustBefore($value)) {
                return [$this->previous, $this];
            }

            return $this->previous->match($value);
        }
    }
}
