<?php

declare(strict_types=1);

namespace FpDbTest\QueryBlockToQueryElementConverter;

use FpDbTest\Converter\ConverterInterface;
use FpDbTest\Exception\QueryPartShouldBeExcludedException;
use FpDbTest\ParseElement\BlockParsedElement;
use FpDbTest\ParseElement\ParsedElementInterface;
use FpDbTest\QueryPart\BlockQueryPart;

/**
 * @template-implements BlockToQueryElementConvertorItemInterface<BlockParsedElement>
 */
class BlockParsedElementConvertor implements BlockToQueryElementConvertorItemInterface
{
    public function __construct(
        private ConverterInterface $argumentConverter,
    )
    {
    }

    public function supports(ParsedElementInterface $element): bool
    {
        return $element instanceof BlockParsedElement;
    }

    public function convert(ParsedElementInterface $element, mixed $argument): BlockQueryPart
    {
        $parameter = $element->getParameter();
        if ($argument === null) {
            throw new QueryPartShouldBeExcludedException(
                new BlockQueryPart(
                    content: $element->getContent(),
                    parameterPositionStart: $parameter->getStart(),
                    parameterLength: $parameter->getLength(),
                    parameterValue: '',
                ),
            );
        }

        return new BlockQueryPart(
            content: $element->getContent(),
            parameterPositionStart: $parameter->getStart(),
            parameterLength: $parameter->getLength(),
            parameterValue: $this->argumentConverter->convertToSqlValue($parameter, $argument),
        );
    }
}