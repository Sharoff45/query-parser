<?php

declare(strict_types=1);

namespace FpDbTest\ParseElement;

readonly abstract class AbstractParsedElement implements ParsedElementInterface
{
    public function __construct(
        private int    $start,
        private int    $end,
        private string $content,
    )
    {
    }

    public function getStart(): int
    {
        return $this->start;
    }

    public function getEnd(): int
    {
        return $this->end;
    }

    public function getLength(): int
    {
        return mb_strlen($this->content);
    }

    public function getContent(): string
    {
        return $this->content;
    }
}