<?php

declare(strict_types=1);

namespace FpDbTest\QueryBlockToQueryElementConverter;

use FpDbTest\Exception\QueryPartShouldBeExcludedException;
use FpDbTest\Exception\ThereAreNoBlockConvertorException;
use FpDbTest\ParseElement\BlockQueryElementCollection;
use FpDbTest\ParseElement\ParsedElementRequireArgumentInterface;
use FpDbTest\Query;

readonly class BlockCollectionToQueryConvertor implements BlockCollectionToQueryConvertorInterface
{
    /**
     * @var BlockToQueryElementConvertorItemInterface[]
     */
    private iterable $convertors;

    public function __construct(
        BlockToQueryElementConvertorItemInterface ...$convertors,
    )
    {
        $this->convertors = $convertors;
    }

    public function convert(BlockQueryElementCollection $blocks, array $arguments): Query
    {
        $queryParts = [];
        $skippedParts = [];
        foreach ($blocks as $block) {
            if ($block instanceof ParsedElementRequireArgumentInterface) {
                $argument = array_shift($arguments);
            } else {
                $argument = null;
            }

            $convertorFound = false;
            foreach ($this->convertors as $convertor) {
                if ($convertor->supports($block)) {
                    $convertorFound = true;
                    try {
                        $queryParts[] = $convertor->convert($block, $argument);
                    } catch (QueryPartShouldBeExcludedException $e) {
                        $skippedParts[] = $e->getQueryPart();
                    }
                    break;
                }
            }

            if (!$convertorFound) {
                throw new ThereAreNoBlockConvertorException($block);
            }
        }

        return new Query(
            queryParts: $queryParts,
            skippedParts: $skippedParts,
        );
    }
}