<?php

declare(strict_types=1);

namespace FpDbTest\ParseElement;

readonly class ParameterParsedElement extends AbstractParsedElement implements ParsedElementRequireArgumentInterface
{
    public function __construct(
        private string $type,
        int            $start,
        int            $end,
        string         $content,
    )
    {
        parent::__construct(
            start: $start,
            end: $end,
            content: $content,
        );
    }

    public function getType(): string
    {
        return $this->type;
    }
}