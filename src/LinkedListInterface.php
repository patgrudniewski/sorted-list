<?php

declare(strict_types=1);

namespace PatGrudniewski\SortedList;

/**
 * @template Type of (int|string)
 */
interface LinkedListInterface
{
    /**
     * @var LinkedListInterface<Type>|null
     */
    public ?LinkedListInterface $previous {
        get;
    }
    /**
     * @var LinkedListInterface<Type>|null
     */
    public ?LinkedListInterface $next {
        get;
    }

    /**
     * @param Type $value
     */
    public function addItem(int|string $value): void;
}
