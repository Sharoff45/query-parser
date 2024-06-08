<?php

declare(strict_types=1);

namespace FpDbTest\Converter;

use FpDbTest\ParseElement\ParameterParsedElement;
use FpDbTest\QueryWalker\ParameterQueryWalker;
use FpDbTest\Utils\StringHelper;

/**
 * @template-implements ConverterItemInterface<string>
 */
readonly class FieldIdentifierConverter implements ConverterItemInterface
{
    public function __construct(
        private StringHelper $stringHelper,
    )
    {
    }

    public function supports(ParameterParsedElement $parameter, mixed $value): bool
    {
        return $parameter->getType() === ParameterQueryWalker::PARAMETER_ARRAY_IDENTITIES
            && is_string($value);
    }

    public function convertToSqlValue(ParameterParsedElement $parameter, $value): string
    {
        return $this->stringHelper->escapeIdentifier($value);
    }
}