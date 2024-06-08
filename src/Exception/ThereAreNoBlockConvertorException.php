<?php

declare(strict_types=1);

namespace FpDbTest\Exception;

use FpDbTest\ParseElement\ParsedElementInterface;

final class ThereAreNoBlockConvertorException extends \Exception implements QueryParserExceptionInterface
{
    public function __construct(
        private readonly ParsedElementInterface $block,
    )
    {
        parent::__construct(
            sprintf(
                'There are no convertor of block type "%s"',
                get_class($this->block),
            ),
        );
    }

    public function getBlock(): ParsedElementInterface
    {
        return $this->block;
    }
}