<?php

declare(strict_types=1);

namespace FpDbTest\ParseElement;

interface ParsedElementInterface
{
    public function getStart(): int;

    public function getEnd(): int;

    public function getLength(): int;

    public function getContent(): string;
}