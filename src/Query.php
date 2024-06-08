<?php

declare(strict_types=1);

namespace FpDbTest;

readonly class Query implements \Stringable
{
    public function __construct(
        private array $queryParts,
        private array $skippedParts = [],
    )
    {
    }

    public function __toString(): string
    {
        return implode('', $this->queryParts);
    }

    public function getQueryParts(): array
    {
        return $this->queryParts;
    }

    public function getSkippedParts(): array
    {
        return $this->skippedParts;
    }
}