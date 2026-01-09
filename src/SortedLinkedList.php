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

    private function compare(int|string $value): int
    {
        return $this->value <=> $value;
    }

    /**
     * @return array{LinkedListInterface, ?LinkedListInterface} | array{?LinkedListInterface, LinkedListInterface}
     */
    private function match(int|string $value): array
    {
        if (0 > $this->compare($value)) {
            if (null === $this->next || 0 < $this->next->compare($value)) {
                return [$this, $this->next];
            }

            return $this->next->match($value);
        } else {
            if (null === $this->previous || 0 > $this->previous->compare($value)) {
                return [$this->previous, $this];
            }

            return $this->previous->match($value);
        }
    }
}
