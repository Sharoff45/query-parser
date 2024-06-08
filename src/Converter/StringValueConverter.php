<?php

declare(strict_types=1);

namespace FpDbTest\Converter;

use FpDbTest\ParseElement\ParameterParsedElement;
use FpDbTest\Utils\StringHelper;

/**
 * @template-implements ConverterItemInterface<string>
 */
readonly class StringValueConverter implements ConverterItemInterface
{
    public function __construct(
        private StringHelper $stringHelper,
    )
    {
    }

    public function supports(ParameterParsedElement $parameter, mixed $value): bool
    {
        return $parameter->getType() === '' && is_string($value);
    }

    public function convertToSqlValue(ParameterParsedElement $parameter, $value): string
    {
        return $this->stringHelper->escapeString($value);
    }
}