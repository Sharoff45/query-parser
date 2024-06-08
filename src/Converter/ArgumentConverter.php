<?php

declare(strict_types=1);

namespace FpDbTest\Converter;

use FpDbTest\Exception\ParameterConvertorNotSupportedArgumentWithValueException;
use FpDbTest\ParseElement\ParameterParsedElement;

readonly class ArgumentConverter implements ConverterInterface
{
    /**
     * @var iterable<ConverterItemInterface>
     */
    private iterable $convertors;

    public function __construct(
        ConverterItemInterface ...$converters,
    )
    {
        $this->convertors = $converters;
    }

    public function convertToSqlValue(ParameterParsedElement $parameter, mixed $value): string
    {
        foreach ($this->convertors as $convertor) {
            if ($convertor->supports($parameter, $value)) {
                return $convertor->convertToSqlValue($parameter, $value);
            }
        }

        throw new ParameterConvertorNotSupportedArgumentWithValueException(
            value: $value,
            parameter: $parameter,
        );
    }
}