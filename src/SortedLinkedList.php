<?php

declare(strict_types=1);

namespace PatGrudniewski\SortedList;

/**
 * @template Type of (int|string)
 * @implements LinkedListInterface<Type>
 */
final class SortedLinkedList implements LinkedListInterface
{
    /**
     * @var LinkedListInterface<Type>|null
     */
    public private(set) ?LinkedListInterface $previous = null;
    /**
     * @var LinkedListInterface<Type>|null
     */
    public private(set) ?LinkedListInterface $next = null;

    /**
     * @param Type $value
     */
    public function __construct(
        public readonly int|string $value,
    ) {
    }

    /**
     * @param Type $value
     */
    public function addItem(int|string $value): void
    {
        if (gettype($value) !== gettype($this->value)) {
            throw new \InvalidArgumentException("Mixing types of items in the list is forbidden");
        }

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

    private function matchesJustAfter(int|string $value): bool
    {
        return $value >= $this->value && (null === $this->next || $value <= $this->next->value);
    }

    private function matchesJustBefore(int|string $value): bool
    {
        return $value <= $this->value && (null === $this->previous || $value >= $this->previous->value);
    }

    /**
     * @return array{LinkedListInterface, ?LinkedListInterface} | array{?LinkedListInterface, LinkedListInterface}
     */
    private function match(int|string $value): array
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
