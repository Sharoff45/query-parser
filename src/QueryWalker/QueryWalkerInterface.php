<?php

declare(strict_types=1);

namespace FpDbTest\QueryWalker;

use FpDbTest\Exception\QueryBlockParseException;
use FpDbTest\ParseElement\BlockQueryElementCollection;

interface QueryWalkerInterface
{
    /**
     * @throws QueryBlockParseException
     */
    public function splitTheQueryToBlocks(string $query): BlockQueryElementCollection;
}