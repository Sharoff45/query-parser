<?php

declare(strict_types=1);

namespace FpDbTest\Converter;

use FpDbTest\ParseElement\ParameterParsedElement;
use FpDbTest\QueryWalker\ParameterQueryWalker;

/**
 * @template-implements ConverterItemInterface<int>
 */
readonly class IntegerValueConverter implements ConverterItemInterface
{
    public function supports(ParameterParsedElement $parameter, mixed $value): bool
    {
        return $parameter->getType() === ParameterQueryWalker::PARAMETER_INTEGER
            && is_int($value);
    }

    public function convertToSqlValue(ParameterParsedElement $parameter, $value): string
    {
        return (string)$value;
    }
}