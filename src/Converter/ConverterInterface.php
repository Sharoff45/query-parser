<?php

declare(strict_types=1);

namespace FpDbTest\Converter;

use FpDbTest\Exception\ParameterConvertorNotSupportedArgumentWithValueException;
use FpDbTest\ParseElement\ParameterParsedElement;

/**
 * @template TValue of mixed
 */
interface ConverterInterface
{
    /**
     * @param TValue $value
     *
     * @throws ParameterConvertorNotSupportedArgumentWithValueException
     */
    public function convertToSqlValue(ParameterParsedElement $parameter, mixed $value): string;
}
