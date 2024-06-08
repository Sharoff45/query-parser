<?php

declare(strict_types=1);

namespace FpDbTest\Converter;

use FpDbTest\ParseElement\ParameterParsedElement;
use FpDbTest\QueryWalker\ParameterQueryWalker;
use FpDbTest\Utils\ArrayHelper;
use FpDbTest\Utils\StringHelper;

/**
 * @template-implements ConverterItemInterface<array<string, string>>
 */
readonly class AssociatedArrayForKeyValueConverter implements ConverterItemInterface
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
            && $this->arrayHelper->isAssociativeArray($value);
    }

    public function convertToSqlValue(ParameterParsedElement $parameter, $value): string
    {
        $result = [];
        foreach ($value as $fieldName => $fieldValue) {
            $result[] = sprintf(
                '%s = %s',
                $this->stringHelper->escapeIdentifier($fieldName),
                $this->stringHelper->escapeNativeVariable($fieldValue),
            );
        }

        return implode(', ', $result);
    }
}