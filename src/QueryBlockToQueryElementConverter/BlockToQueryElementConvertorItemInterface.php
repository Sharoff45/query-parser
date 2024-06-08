<?php

declare(strict_types=1);

namespace FpDbTest\QueryBlockToQueryElementConverter;

use FpDbTest\Exception\ParameterConvertorNotSupportedArgumentWithValueException;
use FpDbTest\Exception\QueryPartShouldBeExcludedException;
use FpDbTest\ParseElement\ParsedElementInterface;
use FpDbTest\QueryPart\QueryPartInterface;

/**
 * @template T of ParsedElementInterface
 */
interface BlockToQueryElementConvertorItemInterface
{
    /**
     * @param T $element
     */
    public function supports(ParsedElementInterface $element): bool;

    /**
     * @param T $element
     *
     * @throws QueryPartShouldBeExcludedException
     * @throws ParameterConvertorNotSupportedArgumentWithValueException
     */
    public function convert(ParsedElementInterface $element, mixed $argument): QueryPartInterface;
}