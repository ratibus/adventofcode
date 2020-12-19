<?php

// Solved in 1h15 :(
$inRuleSection = true;
$messages = [];
$rules = [];
foreach (file(__DIR__.'/input.txt', FILE_IGNORE_NEW_LINES) as $line) {
    if(!strlen($line)) {
        $inRuleSection = false;
        continue;
    }

    if ($inRuleSection) {
        list($ruleNumber, $rule) = explode(': ', $line);

        if (strpos($rule, '"') !== false) {
            $rule = substr($rule, 1, 1);
            $rules[$ruleNumber] = $rule;
        } else {
            $subRules = [];
            foreach (explode(' | ', $rule) as $rulePart) {
                $subRules[] = explode(' ', $rulePart);
            }
            $rules[$ruleNumber] = $subRules;
        }
    } else {
        $messages[] = $line;
    }
}

function getValidMessages($rules, $start) {
    if (!is_array($rules[$start])) {
        return [$rules[$start]];
    }

    $validMessages = [];
    foreach ($rules[$start] as $rulesChunk) {

        $chunkValidMessages = [];
        foreach ($rulesChunk as $ruleIndex => $rule) {
            $subRuleValidMessages = getValidMessages($rules, $rule);
            $newChunkValidMessages = [];
            foreach ($subRuleValidMessages as $subRuleValidMessage) {
                if ($ruleIndex === 0) {
                    $newChunkValidMessages[] = $subRuleValidMessage;
                } else {
                    foreach ($chunkValidMessages as $chunkValidMessage) {
                        $newChunkValidMessages[] = $chunkValidMessage.$subRuleValidMessage;
                    }
                }
            }
            $chunkValidMessages = $newChunkValidMessages;
        }

        foreach ($chunkValidMessages as $chunkValidMessage) {
            $validMessages[$chunkValidMessage] = $chunkValidMessage;
        }
    }

    return $validMessages;
}

$ans = 0;
$validMessages = getValidMessages($rules, 0);
foreach ($messages as $message) {
    if (isset($validMessages[$message])) {
        $ans++;
    }
}
var_dump($ans);