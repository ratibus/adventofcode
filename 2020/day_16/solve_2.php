<?php

// Solved in 51 minutes
$myTicketSection = false;
$myTicket = null;
$nearbyTicketsSection = false;
$nearbyTickets = [];
$fields = [];

foreach (file(__DIR__.'/input_2_test.txt', FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES) as $line) {
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

printf("Nb nearby tickets: %d\n", count($nearbyTickets));

$invalidValues = [];
$validTickets = $nearbyTickets;
foreach ($nearbyTickets as $nearbyTicketIndex => $nearbyTicket) {
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
            unset($validTickets[$nearbyTicketIndex]);
        }
    }
}
$validTickets[] = $myTicket;
printf("Nb valid tickets: %d\n", count($validTickets));

$possibleFieldPositions = [];

for ($i = 0; $i < count($fields); $i++) {

    foreach ($fields as $fieldName => $fieldRanges) {

        $isValidField = true;
        foreach ($validTickets as $validTicket) {
            $isValidFieldForTicket = false;
            foreach ($fieldRanges as $fieldRange) {
                if ($validTicket[$i] >= $fieldRange['min'] && $validTicket[$i] <= $fieldRange['max']) {
                    $isValidFieldForTicket = true;
                    break;
                }
            }
            if (!$isValidFieldForTicket) {
                $isValidField = false;
                break;
            }
        }

        if ($isValidField) {
            $possibleFieldPositions[$fieldName][$i] = $i;
        }
    }
}

$fieldPositions = $possibleFieldPositions;
$fieldPositions = [];
while (count($fieldPositions) < count($fields)) {

    foreach ($possibleFieldPositions as $fieldName => $possiblePositions) {
        if (count($possiblePositions) === 1) {
            $validPosition = array_pop($possiblePositions);
            $fieldPositions[$fieldName] = $validPosition;

            foreach ($possibleFieldPositions as $fieldName => $possiblePositions) {
                unset($possiblePositions[$validPosition]);
                $possibleFieldPositions[$fieldName] = $possiblePositions;
            }
        }
    }
}

$ans = 1;
foreach ($fieldPositions as $fieldName => $position) {
    if (strpos($fieldName, 'departure') === 0) {
        $ans *= $myTicket[$position];
    }
}

var_dump($ans);
