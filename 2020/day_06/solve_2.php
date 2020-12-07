<?php

// Solved in 6 minutes
$inputFile = __DIR__ . '/input.txt';

$groupsAnswers = getGroupsAnswers($inputFile);
debug($groupsAnswers);

$sumGroupsAnswers = 0;
foreach ($groupsAnswers as $groupAnswers) {

    $singleAnswers = explode(' ', $groupAnswers);
    $groupSize = count($singleAnswers);

    $nbAnswersByQuestion = [];
    foreach ($singleAnswers as $singleAnswer) {
        $answers = str_split($singleAnswer);
        foreach ($answers as $answer) {
            if (!isset($nbAnswersByQuestion[$answer])) {
                $nbAnswersByQuestion[$answer] = 0;
            }
            $nbAnswersByQuestion[$answer]++;
        }
    }

    debug($groupSize);
    debug($nbAnswersByQuestion);

    foreach ($nbAnswersByQuestion as $nbAnswers) {
        if ($nbAnswers === $groupSize) {
            $sumGroupsAnswers++;
        }
    }
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