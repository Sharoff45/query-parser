<?php

declare(strict_types=1);

namespace FpDbTest\QueryWalker;

use FpDbTest\Exception\QueryBlockParseException;
use FpDbTest\ParseElement\BlockQueryElementCollection;

readonly class QueryWalker implements QueryWalkerInterface
{
    /**
     * @var iterable<QueryWalkerItemInterface>
     */
    private array $walkers;

    public function __construct(
        QueryWalkerItemInterface ...$walkers,
    )
    {
        $this->walkers = $walkers;
    }

    public function splitTheQueryToBlocks(string $query): BlockQueryElementCollection
    {
        $queryLength = mb_strlen($query);

        $blocks = new BlockQueryElementCollection();
        $startPosition = null;

        $walkers = $this->getPrioritisedWalkers();
        $currentWalker = null;
        for ($position = 0; $position < $queryLength; $position++) {
            $symbol = $query[$position];
            $nextPosition = $position + 1;
            $nextSymbol = $nextPosition >= $queryLength ? null : $query[$nextPosition];

            if ($startPosition === null) {
                foreach ($walkers as $walker) {
                    if ($walker->isStartSymbol($symbol)) {
                        $startPosition = $position;
                        $currentWalker = $walker;
                        break;
                    }
                }

                if ($startPosition === null) {
                    throw new QueryBlockParseException(
                        sprintf(
                            'No walkers for position "%d" in query "%s"',
                            $position,
                            $query,
                        ),
                    );
                }
            } elseif ($currentWalker->isDisableSymbol($symbol)) {
                throw new QueryBlockParseException(
                    sprintf(
                        'Not expected symbol "%s" at position %d in query "%s" by walker "%s"',
                        $symbol,
                        $position,
                        $query,
                        get_debug_type($currentWalker),
                    ),
                );
            }

            if ($currentWalker->isEndSymbol($symbol, $nextSymbol)) {
                $blocks->append(
                    $currentWalker->createBlock(
                        startPosition: $startPosition,
                        endPosition: $position,
                        fullQuery: $query,
                    ),
                );
                $startPosition = null;
                $currentWalker = null;
                continue;
            }
        }

        if ($currentWalker !== null && $startPosition !== null) {
            $blocks->append(
                $currentWalker->createBlock(
                    startPosition: $startPosition,
                    endPosition: $position,
                    fullQuery: $query,
                ),
            );
        }

        return $blocks;
    }

    private function getPrioritisedWalkers(): array
    {
        $walkers = $this->walkers;
        usort($walkers, static function (QueryWalkerItemInterface $a, QueryWalkerItemInterface $b): int {
            return $a->getPriority() <=> $b->getPriority();
        });

        return $walkers;
    }
}