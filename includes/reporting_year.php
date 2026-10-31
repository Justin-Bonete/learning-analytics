<?php

const REPORTING_YEAR_LAST_START = 2039;

function formatReportingYear($year): string
{
    $yearNumber = filter_var($year, FILTER_VALIDATE_INT);
    if ($yearNumber === false) {
        return (string)$year;
    }

    if ($yearNumber >= (int)date('Y') && $yearNumber <= REPORTING_YEAR_LAST_START) {
        return $yearNumber . ' - ' . ($yearNumber + 1);
    }

    return (string)$yearNumber;
}
