<?php

declare(strict_types=1);

namespace FpDbTest\QueryWalker;

use FpDbTest\Exception\QueryBlockParseException;
use FpDbTest\ParseElement\ParsedElementInterface;

interface QueryWalkerItemInterface
{
    public function isStartSymbol(string $currentSymbol): bool;

    public function isDisableSymbol(string $symbol): bool;

    public function isEndSymbol(string $symbol, ?string $nextSymbol): bool;

    public function getPriority(): int;

    /**
     * @throws QueryBlockParseException
     */
    public function createBlock(int $startPosition, int $endPosition, string $fullQuery): ParsedElementInterface;
}