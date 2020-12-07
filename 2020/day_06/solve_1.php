<?php

// Solved in 11 minutes
$inputFile = __DIR__ . '/input.txt';

$groupsAnswers = getGroupsAnswers($inputFile);
debug($groupsAnswers);

$sumGroupsAnswers = 0;
foreach ($groupsAnswers as $groupAnswers) {
    $groupAnswers = array_unique(str_split(str_replace(' ', '', $groupAnswers)));
    debug($groupAnswers);

    $sumGroupsAnswers += count($groupAnswers);
}

var_dump($sumGroupsAnswers);

function getGroupsAnswers($inputFile) {

    $groupsAnswers = [];

    $groupAnswers = '';
    foreach (file($inputFile, FILE_IGNORE_NEW_LINES) as $line) {
        if (strlen($line) == 0) {
            $groupsAnswers[] = trim($groupAnswers);
            $groupAnswers = '';
            continue;
        }

        $groupAnswers .= ' '.$line;
    }
    $groupsAnswers[] = trim($groupAnswers);
    return $groupsAnswers;
}

function debug($v) {
    //print_r($v);
}