<?php

declare(strict_types=1);

namespace FpDbTest\Exception;

use FpDbTest\ParseElement\ParsedElementInterface;

final class ParameterConvertorNotSupportedArgumentWithValueException extends \Exception implements QueryParserExceptionInterface
{
    public function __construct(
        private readonly mixed                  $value,
        private readonly ParsedElementInterface $parameter,
    )
    {
        parent::__construct(
            sprintf(
                'Unable to convert argument "%s" to SQL value with "%s" type',
                get_debug_type($value),
                $parameter->getType() ?: 'default',
            ),
        );
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function getParameter(): ParsedElementInterface
    {
        return $this->parameter;
    }
}