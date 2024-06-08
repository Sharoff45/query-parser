<?php

declare(strict_types=1);

namespace FpDbTest\QueryWalker;

use FpDbTest\Exception\QueryBlockParseException;
use FpDbTest\ParseElement\BlockParsedElement;
use FpDbTest\ParseElement\ParsedElementInterface;

readonly class BlockQueryWalker implements QueryWalkerItemInterface
{
    public const string START_BLOCK_SYMBOL = '{';
    public const string END_BLOCK_SYMBOL = '}';

    public function __construct(
        private ParameterQueryWalker $parameterQueryWalker,
    )
    {
    }

    #[\Override]
    public function isDisableSymbol(string $symbol): bool
    {
        return $symbol === self::START_BLOCK_SYMBOL;
    }

    #[\Override]
    public function getPriority(): int
    {
        return 50;
    }

    #[\Override]
    public function createBlock(int $startPosition, int $endPosition, string $fullQuery): ParsedElementInterface
    {
        $blockQuery = mb_substr($fullQuery, $startPosition, $endPosition - $startPosition + 1);
        $blockQuery = trim($blockQuery, '{}');
        $blockQueryLength = mb_strlen($blockQuery);

        $parameterStartPosition = null;
        $parameterEndPosition = null;
        for ($i = 0; $i < $blockQueryLength; $i++) {
            $current = $blockQuery[$i];
            if ($parameterStartPosition === null && $this->parameterQueryWalker->isStartSymbol($current)) {
                $parameterStartPosition = $i;
                continue;
            }

            if ($parameterStartPosition === null) {
                continue;
            }

            $nextPosition = $i + 1;
            $nextSymbol = $blockQuery[$nextPosition] ?? null;
            if ($this->parameterQueryWalker->isEndSymbol($current, $nextSymbol)) {
                $parameterEndPosition = $i;
                break;
            }
        }

        if ($parameterEndPosition === null) {
            throw new QueryBlockParseException(
                sprintf(
                    'Unable to find parameter in block query "%s"',
                    $blockQuery,
                ),
            );
        }

        $parameterElement = $this->parameterQueryWalker->createBlock(
            $parameterStartPosition,
            $parameterEndPosition,
            $blockQuery,
        );

        return new BlockParsedElement(
            parameter: $parameterElement,
            start: $startPosition,
            end: $endPosition,
            content: $blockQuery,
        );
    }

    #[\Override] public function isStartSymbol(string $currentSymbol): bool
    {
        return $currentSymbol === self::START_BLOCK_SYMBOL;
    }

    #[\Override] public function isEndSymbol(string $symbol, ?string $nextSymbol): bool
    {
        return $symbol === self::END_BLOCK_SYMBOL;
    }
}