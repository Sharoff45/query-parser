<?php

declare(strict_types=1);

namespace FpDbTest\Converter;

use FpDbTest\ParseElement\ParameterParsedElement;

/**
 * @template TValue of mixed
 * @template-extends ConverterInterface<TValue>
 */
interface ConverterItemInterface extends ConverterInterface
{
    /**
     * @param TValue $value
     */
    public function supports(ParameterParsedElement $parameter, mixed $value): bool;
}