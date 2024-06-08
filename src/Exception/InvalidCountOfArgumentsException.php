<?php

declare(strict_types=1);

namespace FpDbTest\Exception;

use FpDbTest\QueryPart\QueryPartInterface;

final class InvalidCountOfArgumentsException extends \Exception implements QueryPartInterface
{
    public function __construct(
        private readonly int $countPlaceholders,
        private readonly int $countArguments,
    )
    {
        parent::__construct(
            sprintf(
                'Invalid count of arguments. Expected: %d but %d given',
                $this->countPlaceholders,
                $this->countArguments,
            ),
        );
    }

    public function getCountPlaceholders(): int
    {
        return $this->countPlaceholders;
    }

    public function getCountArguments(): int
    {
        return $this->countArguments;
    }
}