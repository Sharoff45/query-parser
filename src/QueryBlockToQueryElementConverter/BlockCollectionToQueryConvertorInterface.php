<?php

declare(strict_types=1);

namespace FpDbTest\QueryBlockToQueryElementConverter;

use FpDbTest\Exception\ParameterConvertorNotSupportedArgumentWithValueException;
use FpDbTest\Exception\ThereAreNoBlockConvertorException;
use FpDbTest\ParseElement\BlockQueryElementCollection;
use FpDbTest\Query;

interface BlockCollectionToQueryConvertorInterface
{
    /**
     * @throws ThereAreNoBlockConvertorException
     * @throws ParameterConvertorNotSupportedArgumentWithValueException
     */
    public function convert(BlockQueryElementCollection $blocks, array $arguments): Query;
}