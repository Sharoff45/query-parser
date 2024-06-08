#!/usr/bin/env php
<?php

$maxAttempts = 30;
$timeoutInSeconds = 1;

for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {
    echo sprintf("Connection attempt #%d to MySQL\n", $attempt);
    try {
        $mysqli = @new mysqli('127.0.0.1', 'root', 'root', 'database', 3306);
        echo sprintf("Connection successful. attempt #%d\n", $attempt);
        break;
    } catch (mysqli_sql_exception $e) {
        echo sprintf("Error connecting to MySQL: %s\n", $e->getMessage());

        if ($attempt < $maxAttempts) {
            echo sprintf("Will retry in %d second(s)\n", $timeoutInSeconds);
        }

        sleep($timeoutInSeconds);
    }
}
