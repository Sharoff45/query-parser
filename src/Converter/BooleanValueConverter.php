<?php

declare(strict_types=1);

namespace FpDbTest\Converter;

use FpDbTest\ParseElement\ParameterParsedElement;
use FpDbTest\QueryWalker\ParameterQueryWalker;

/**
 * @template-implements ConverterItemInterface<bool>
 */
readonly class BooleanValueConverter implements ConverterItemInterface
{
    public function supports(ParameterParsedElement $parameter, mixed $value): bool
    {
        return $parameter->getType() === ParameterQueryWalker::PARAMETER_INTEGER
            && is_bool($value);
    }

    public function convertToSqlValue(ParameterParsedElement $parameter, $value): string
    {
        return ($value === true ? '1' : '0');
    }
}