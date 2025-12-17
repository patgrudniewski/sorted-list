<?php

declare(strict_types=1);

use PatGrudniewski\SortedList\SortedLinkedList;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class SortedLinkedListTest extends TestCase
{
    public static function provideData(): iterable
    {
        yield 'lowest element is added to the beginning of the list' => [2, [1], [1, 2]];

        yield 'greatest element is added to the end of the list' => [2, [3], [2, 3]];

        yield 'elements with same value added' => [
            2,
            [2, 2, 2],
            [2, 2, 2, 2],
        ];

        yield 'element is added to the list in order' => [
            8,
            [2, 5, 3, 1, 21, 13, 34],
            [1, 2, 3, 5, 8, 13, 21, 34],
        ];
    }

    #[DataProvider('provideData', false), Test]
    public function newlyCreatedListDoesIsNotLinked(int $initialValue): void
    {
        $handle = new SortedLinkedList($initialValue);

        self::assertNull($handle->next);
        self::assertNull($handle->previous);
    }

    #[DataProvider('provideData', false), Test]
    public function createdListContainsValidValue(int $initialValue): void
    {
        $handle = new SortedLinkedList($initialValue);

        self::assertSame($initialValue, $handle->value);
    }

    #[DataProvider('provideData'), Test]
    public function ordersListElements(
        int $initialValue,
        array $otherValues,
        array $expectedOrder,
    ): void {
        $handle = new SortedLinkedList($initialValue);
        foreach ($otherValues as $value) {
            $handle->addItem($value);
        }

        while ($handle->previous) {
            $handle = $handle->previous;
        }

        foreach ($expectedOrder as $value) {
            self::assertSame($value, $handle->value);
            if ($handle->next) {
                $handle = $handle->next;
            }
        }
    }
}
