<?php

declare(strict_types=1);

namespace PatGrudniewski\SortedList;

interface LinkedListInterface
{
    public ?LinkedListInterface $previous {
        get;
    }
    public ?LinkedListInterface $next {
        get;
    }

    public function addItem(int $value): void;
}
