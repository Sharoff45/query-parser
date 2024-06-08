<?php

declare(strict_types=1);

namespace FpDbTest\QueryBlockToQueryElementConverter;

use FpDbTest\Converter\ConverterInterface;
use FpDbTest\Exception\QueryPartShouldBeExcludedException;
use FpDbTest\ParseElement\BlockParsedElement;
use FpDbTest\ParseElement\ParameterParsedElement;
use FpDbTest\ParseElement\ParsedElementInterface;
use FpDbTest\QueryPart\BlockQueryPart;
use FpDbTest\QueryPart\StaticQueryPart;

/**
 * @template-implements BlockToQueryElementConvertorItemInterface<ParameterParsedElement>
 */
readonly class ParameterParsedElementConvertor implements BlockToQueryElementConvertorItemInterface
{
    public function __construct(
        private ConverterInterface $argumentConverter,
    )
    {
    }

    public function supports(ParsedElementInterface $element): bool
    {
        return $element instanceof ParameterParsedElement;
    }

    public function convert(ParsedElementInterface $element, mixed $argument): StaticQueryPart
    {
        return new StaticQueryPart($this->argumentConverter->convertToSqlValue($element, $argument));
    }
}