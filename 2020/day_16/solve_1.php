<?php

// Solved in 18 minutes
$myTicketSection = false;
$myTicket = null;
$nearbyTicketsSection = false;
$nearbyTickets = [];
$fields = [];

foreach (file(__DIR__.'/input.txt', FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES) as $line) {
    if (strpos($line, 'your ticket') !== false) {
        $myTicketSection = true;
    } elseif ($myTicketSection === true) {
        $myTicket = explode(',', $line);
        $myTicketSection = false;
    } elseif (strpos($line, 'nearby ticket') !== false) {
        $nearbyTicketsSection = true;
    } elseif ($nearbyTicketsSection === true) {
        $nearbyTickets[] = explode(',', $line);
    } elseif (preg_match('/^(.*): (\d+)-(\d+) or (\d+)-(\d+)$/', $line, $matches)) {
        $fields[$matches[1]] = [
            ['min' => $matches[2], 'max' => $matches[3]],
            ['min' => $matches[4], 'max' => $matches[5]],
        ];
    }
}

$invalidValues = [];
foreach ($nearbyTickets as $nearbyTicket) {
    foreach ($nearbyTicket as $fieldValue) {
        $isFieldValueValid = false;
        foreach ($fields as $field) {
            foreach ($field as $range) {
                if ($fieldValue >= $range['min'] && $fieldValue <= $range['max']) {
                    $isFieldValueValid = true;
                    break 2;
                }
            }
        }
        if (!$isFieldValueValid) {
            $invalidValues[] = $fieldValue;
        }
    }
}

var_dump(array_sum($invalidValues));
