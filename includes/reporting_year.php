<?php

const REPORTING_YEAR_LAST_START = 2039;
const REPORTING_YEAR_FIRST_START = 2024;

function getAvailableReportingYearStarts(): array
{
    $currentYear = (int)date('Y');

    return $currentYear < REPORTING_YEAR_FIRST_START
        ? []
        : range($currentYear, REPORTING_YEAR_FIRST_START);
}

function formatReportingYearOption($year): string
{
    $yearNumber = filter_var($year, FILTER_VALIDATE_INT);
    if ($yearNumber === false) {
        return (string)$year;
    }

    return $yearNumber . ' - ' . ($yearNumber + 1);
}

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
