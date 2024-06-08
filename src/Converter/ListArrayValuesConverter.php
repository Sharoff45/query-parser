<?php

declare(strict_types=1);

namespace FpDbTest\Converter;

use FpDbTest\ParseElement\ParameterParsedElement;
use FpDbTest\QueryWalker\ParameterQueryWalker;
use FpDbTest\Utils\ArrayHelper;
use FpDbTest\Utils\StringHelper;

/**
 * @template-implements ConverterItemInterface<array<int, mixed>>
 */
readonly class ListArrayValuesConverter implements ConverterItemInterface
{
    public function __construct(
        private ArrayHelper  $arrayHelper,
        private StringHelper $stringHelper,
    )
    {
    }

    public function supports(ParameterParsedElement $parameter, mixed $value): bool
    {
        return $parameter->getType() === ParameterQueryWalker::PARAMETER_ARRAY
            && is_array($value)
            && !$this->arrayHelper->isAssociativeArray($value);
    }

    public function convertToSqlValue(ParameterParsedElement $parameter, $value): string
    {
        $result = [];
        foreach ($value as $fieldValue) {
            $result[] = $this->stringHelper->escapeNativeVariable($fieldValue);
        }

        return implode(', ', $result);
    }
}