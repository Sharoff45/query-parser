<?php

declare(strict_types=1);

namespace FpDbTest\SqlEscaper;

use mysqli;

readonly class MysqliEscaper implements SqlEscaperInterface
{
    public function __construct(
        private mysqli $mysqli,
    )
    {
    }

    public function escapeString(string $string): string
    {
        return mysqli_real_escape_string($this->mysqli, $string);
    }
}