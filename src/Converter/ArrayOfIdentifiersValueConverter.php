<?php

declare(strict_types=1);

namespace FpDbTest\Converter;

use FpDbTest\ParseElement\ParameterParsedElement;
use FpDbTest\QueryWalker\ParameterQueryWalker;
use FpDbTest\Utils\ArrayHelper;
use FpDbTest\Utils\StringHelper;

/**
 * @template-implements ConverterItemInterface<array<int, string>>
 */
readonly class ArrayOfIdentifiersValueConverter implements ConverterItemInterface
{
    public function __construct(
        private ArrayHelper  $arrayHelper,
        private StringHelper $stringHelper,
    )
    {
    }

    public function supports(ParameterParsedElement $parameter, mixed $value): bool
    {
        return $parameter->getType() === ParameterQueryWalker::PARAMETER_ARRAY_IDENTITIES
            && is_array($value)
            && !$this->arrayHelper->isAssociativeArray($value);
    }

    public function convertToSqlValue(ParameterParsedElement $parameter, $value): string
    {
        $values = array_map(fn($field) => $this->stringHelper->escapeIdentifier($field), $value);

        return implode(', ', $values);
    }
}