<?php

declare(strict_types=1);

namespace FpDbTest\Utils;

use FpDbTest\SqlEscaper\SqlEscaperInterface;

readonly class StringHelper
{
    public function __construct(
        private SqlEscaperInterface $sqlEscaper,
    )
    {
    }

    public function escapeNativeVariable(mixed $value): string
    {
        return (string)match (get_debug_type($value)) {
            'int', 'bool' => (int)$value,
            'float' => (float)$value,
            'null' => 'NULL',
            'string' => $this->escapeString($value),
            default => throw new \RuntimeException(sprintf('Unable to convert field value of type %s', get_debug_type($value))),
        };
    }

    public function escapeString(string $string): string
    {
        return sprintf("'%s'", $this->sqlEscaper->escapeString($string));
    }

    public function escapeIdentifier(string $identifier): string
    {
        $result = preg_replace('/(\w+)/', '`$1`', $identifier);

        return str_replace('`as`', 'as', $result);
    }
}