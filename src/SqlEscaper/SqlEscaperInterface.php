<?php

declare(strict_types=1);

namespace FpDbTest\SqlEscaper;

interface SqlEscaperInterface
{
    public function escapeString(string $string): string;
}