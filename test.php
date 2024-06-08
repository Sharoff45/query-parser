#!/usr/bin/env php
<?php

use FpDbTest\Converter\ArgumentConverter;
use FpDbTest\Converter\ArrayOfIdentifiersValueConverter;
use FpDbTest\Converter\AssociatedArrayForKeyValueConverter;
use FpDbTest\Converter\BooleanValueConverter;
use FpDbTest\Converter\FieldIdentifierConverter;
use FpDbTest\Converter\IntegerValueConverter;
use FpDbTest\Converter\ListArrayValuesConverter;
use FpDbTest\Converter\StringValueConverter;
use FpDbTest\Database;
use FpDbTest\DatabaseTest;
use FpDbTest\QueryBlockToQueryElementConverter\BlockCollectionToQueryConvertor;
use FpDbTest\QueryBlockToQueryElementConverter\BlockParsedElementConvertor;
use FpDbTest\QueryBlockToQueryElementConverter\ParameterParsedElementConvertor;
use FpDbTest\QueryBlockToQueryElementConverter\StaticParsedElementConvertor;
use FpDbTest\QueryParser;
use FpDbTest\QueryWalker\BlockQueryWalker;
use FpDbTest\QueryWalker\ParameterQueryWalker;
use FpDbTest\QueryWalker\QueryWalker;
use FpDbTest\QueryWalker\StaticQueryWalker;
use FpDbTest\SqlEscaper\MysqliEscaper;
use FpDbTest\Utils\ArrayHelper;
use FpDbTest\Utils\StringHelper;

require_once 'vendor/autoload.php';

$mysqli = @new mysqli('127.0.0.1', 'root', 'root', 'database', 3306);
if ($mysqli->connect_errno) {
    throw new Exception($mysqli->connect_error);
}

$sqlEscaper = new MysqliEscaper($mysqli);
$arrayHelper = new ArrayHelper();
$stringHelper = new StringHelper($sqlEscaper);
$argumentConverter = new ArgumentConverter(
    new StringValueConverter(
        stringHelper: $stringHelper,
    ),
    new ArrayOfIdentifiersValueConverter(
        arrayHelper: $arrayHelper,
        stringHelper: $stringHelper,
    ),
    new IntegerValueConverter(),
    new BooleanValueConverter(),
    new AssociatedArrayForKeyValueConverter(
        arrayHelper: $arrayHelper,
        stringHelper: $stringHelper,
    ),
    new FieldIdentifierConverter(
        stringHelper: $stringHelper,
    ),
    new ListArrayValuesConverter(
        arrayHelper: $arrayHelper,
        stringHelper: $stringHelper,
    ),
);

$parameterQueryWalker = new ParameterQueryWalker();

$blockToQueryConvertor = new BlockCollectionToQueryConvertor(
    new BlockParsedElementConvertor($argumentConverter),
    new ParameterParsedElementConvertor($argumentConverter),
    new StaticParsedElementConvertor(),
);

$queryParser = new QueryParser(
    queryWalker: new QueryWalker(
        new StaticQueryWalker([
            BlockQueryWalker::START_BLOCK_SYMBOL,
            BlockQueryWalker::END_BLOCK_SYMBOL,
            ParameterQueryWalker::PARAMETER_IDENTIFIER,
        ]),
        new BlockQueryWalker($parameterQueryWalker),
        $parameterQueryWalker,
    ),
    blockCollectionToQueryConvertor: $blockToQueryConvertor,
);

$db = new Database($queryParser);
$test = new DatabaseTest($db);
$test->testBuildQuery();

exit('OK');
