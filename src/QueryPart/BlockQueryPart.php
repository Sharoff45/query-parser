<?php

declare(strict_types=1);

namespace FpDbTest\QueryPart;

readonly class BlockQueryPart implements QueryPartInterface
{
    public function __construct(
        private string $content,
        private int    $parameterPositionStart,
        private int    $parameterLength,
        private string $parameterValue,
    )
    {
    }

    #[\Override]
    public function __toString(): string
    {
        return substr_replace(
            $this->content,
            $this->parameterValue,
            $this->parameterPositionStart,
            $this->parameterLength,
        );
    }
}