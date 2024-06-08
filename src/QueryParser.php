<?php

declare(strict_types=1);

namespace FpDbTest;

use FpDbTest\Exception\InvalidCountOfArgumentsException;
use FpDbTest\Exception\ParameterConvertorNotSupportedArgumentWithValueException;
use FpDbTest\Exception\QueryBlockParseException;
use FpDbTest\Exception\ThereAreNoBlockConvertorException;
use FpDbTest\QueryBlockToQueryElementConverter\BlockCollectionToQueryConvertorInterface;
use FpDbTest\QueryWalker\QueryWalkerInterface;

readonly class QueryParser
{
    public function __construct(
        private QueryWalkerInterface                     $queryWalker,
        private BlockCollectionToQueryConvertorInterface $blockCollectionToQueryConvertor,
    )
    {
    }

    /**
     * @throws ThereAreNoBlockConvertorException
     * @throws ParameterConvertorNotSupportedArgumentWithValueException
     * @throws InvalidCountOfArgumentsException
     * @throws QueryBlockParseException
     */
    public function parse(string $query, array $args): Query
    {
        $this->checkCountArgumentsAndPlaceholders($query, $args);
        $blocks = $this->queryWalker->splitTheQueryToBlocks($query);

        return $this->blockCollectionToQueryConvertor->convert($blocks, $args);
    }

    /**
     * @throws InvalidCountOfArgumentsException
     */
    private function checkCountArgumentsAndPlaceholders(string $query, array $args): void
    {
        $countPlaceholders = mb_substr_count($query, '?');
        $countArguments = count($args);
        $isQueryWithAllArguments = $countArguments === $countPlaceholders;

        if (!$isQueryWithAllArguments) {
            throw new InvalidCountOfArgumentsException(
                countPlaceholders: $countPlaceholders,
                countArguments: $countArguments,
            );
        }
    }
}