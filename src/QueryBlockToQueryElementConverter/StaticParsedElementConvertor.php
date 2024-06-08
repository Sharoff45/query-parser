<?php

declare(strict_types=1);

namespace FpDbTest\QueryBlockToQueryElementConverter;

use FpDbTest\ParseElement\ParsedElementInterface;
use FpDbTest\ParseElement\StaticParsedElement;
use FpDbTest\QueryPart\QueryPartInterface;
use FpDbTest\QueryPart\StaticQueryPart;

/**
 * @template-implements BlockToQueryElementConvertorItemInterface<StaticParsedElement>
 */
class StaticParsedElementConvertor implements BlockToQueryElementConvertorItemInterface
{
    public function supports(ParsedElementInterface $element): bool
    {
        return $element instanceof StaticParsedElement;
    }

    public function convert(ParsedElementInterface $element, mixed $argument): StaticQueryPart
    {
        return new StaticQueryPart($element->getContent());
    }
}