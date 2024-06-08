<?php

namespace FpDbTest;

class Database implements DatabaseInterface
{
    private ?Query $lastQuery;

    public function __construct(
        private readonly QueryParser $queryParser,
    )
    {
    }

    public function buildQuery(string $query, array $args = []): string
    {
        $this->lastQuery = $this->queryParser->parse($query, $args);

        return (string)$this->lastQuery;
    }

    public function skip(): ?array
    {
        if (!isset($this->lastQuery) || count($this->lastQuery->getSkippedParts()) === 0) {
            return null;
        }

        return $this->lastQuery->getSkippedParts();
    }
}
