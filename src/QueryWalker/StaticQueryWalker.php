<?php

declare(strict_types=1);

namespace FpDbTest\QueryWalker;

use FpDbTest\ParseElement\ParsedElementInterface;
use FpDbTest\ParseElement\StaticParsedElement;
use Override;

readonly class StaticQueryWalker implements QueryWalkerItemInterface
{
    public function __construct(
        private array $registeredSymbols,
    )
    {
    }

    #[Override] public function isStartSymbol(string $currentSymbol): bool
    {
        return !in_array($currentSymbol, $this->registeredSymbols, true);
    }

    #[Override] public function isDisableSymbol(string $symbol): bool
    {
        return false;
    }

    #[Override] public function isEndSymbol(string $symbol, ?string $nextSymbol): bool
    {
        return $nextSymbol === null || in_array($nextSymbol, $this->registeredSymbols, true);
    }

    #[Override] public function getPriority(): int
    {
        return 10000;
    }

    #[Override] public function createBlock(int $startPosition, int $endPosition, string $fullQuery): ParsedElementInterface
    {
        return new StaticParsedElement(
            start: $startPosition,
            end: $endPosition,
            content: mb_substr($fullQuery, $startPosition, $endPosition - $startPosition + 1),
        );
    }
}