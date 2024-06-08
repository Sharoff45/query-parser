<?php

declare(strict_types=1);

namespace FpDbTest\QueryWalker;

use FpDbTest\ParseElement\ParameterParsedElement;

readonly class ParameterQueryWalker implements QueryWalkerItemInterface
{
    public const string PARAMETER_IDENTIFIER = '?';
    public const string PARAMETER_INTEGER = 'd';
    public const string PARAMETER_FLOAT = 'f';
    public const string PARAMETER_ARRAY = 'a';
    public const string PARAMETER_ARRAY_IDENTITIES = '#';
    private const array REGISTERED_TYPES = [
        self::PARAMETER_IDENTIFIER,
        self::PARAMETER_INTEGER,
        self::PARAMETER_FLOAT,
        self::PARAMETER_ARRAY,
        self::PARAMETER_ARRAY_IDENTITIES,
    ];

    #[\Override]
    public function isStartSymbol(string $currentSymbol): bool
    {
        return $currentSymbol === self::PARAMETER_IDENTIFIER;
    }

    #[\Override]
    public function isDisableSymbol(string $symbol): bool
    {
        return false;
    }

    #[\Override]
    public function isEndSymbol(string $symbol, ?string $nextSymbol): bool
    {
        if ($nextSymbol === null) {
            return true;
        }

        return !in_array(mb_strtolower($nextSymbol), self::REGISTERED_TYPES, true);
    }

    #[\Override]
    public function getPriority(): int
    {
        return 20;
    }

    #[\Override]
    public function createBlock(int $startPosition, int $endPosition, string $fullQuery): ParameterParsedElement
    {
        $type = trim(mb_substr($fullQuery, $startPosition, $endPosition - $startPosition + 1), '?');

        return new ParameterParsedElement(
            type: mb_strtolower($type),
            start: $startPosition,
            end: $endPosition,
            content: sprintf('?%s', $type),
        );
    }
}