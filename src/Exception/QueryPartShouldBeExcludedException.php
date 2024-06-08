<?php

declare(strict_types=1);

namespace FpDbTest\Exception;

use FpDbTest\QueryPart\QueryPartInterface;

final class QueryPartShouldBeExcludedException extends \Exception implements QueryParserExceptionInterface
{
    public function __construct(
        private readonly QueryPartInterface $queryPart,
    )
    {
        parent::__construct('Query part should be excluded from query');
    }

    public function getQueryPart(): QueryPartInterface
    {
        return $this->queryPart;
    }
}