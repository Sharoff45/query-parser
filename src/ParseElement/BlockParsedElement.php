<?php

declare(strict_types=1);

namespace FpDbTest\ParseElement;

readonly class BlockParsedElement extends AbstractParsedElement implements ParsedElementRequireArgumentInterface
{
    public function __construct(
        private ParameterParsedElement $parameter,
        int                            $start,
        int                            $end,
        string                         $content,
    )
    {
        parent::__construct(
            start: $start,
            end: $end,
            content: $content,
        );
    }

    public function getParameter(): ParameterParsedElement
    {
        return $this->parameter;
    }
}