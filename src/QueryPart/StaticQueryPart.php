<?php

declare(strict_types=1);

namespace FpDbTest\QueryPart;

readonly class StaticQueryPart implements QueryPartInterface
{
    public function __construct(private string $content)
    {
    }

    #[\Override]
    public function __toString(): string
    {
        return $this->content;
    }
}