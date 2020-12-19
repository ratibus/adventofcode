<?php

// Solved in about 2h
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


/**
 * Starting rules are :
 * 0: 8 11
 * 8: 42 | 42 8
 * 11: 42 31 | 42 11 31
 *
 * Which is equivalent to have our messages matching the rule: 42{n} 31 {m} with n>1, m>0 and m<n
 *
 * Pattern from 42 and 31 have the same length
 */

$validPrefixes = getValidMessages($rules, 42);
$validSuffixes = getValidMessages($rules, 31);

$chunkLength = 8; // 5 for sample data
$ans = 0;
foreach ($messages as $message) {
    if (strlen($message) % $chunkLength !== 0) {
        continue;
    }

    $prefixIndexes = [];
    $suffixIndexes = [];
    $chunks = array_chunk(str_split($message), $chunkLength);
    foreach ($chunks as $chunkIndex => $chunkChars) {
        $chunk = implode($chunkChars);

        if (isset($validPrefixes[$chunk])) {
            $prefixIndexes[$chunkIndex] = $chunkIndex;
        } elseif(isset($validSuffixes[$chunk])) {
            $suffixIndexes[$chunkIndex] = $chunkIndex;
        }
    }

    if (count($prefixIndexes) + count($suffixIndexes) !== count($chunks)) { // At least one chunk is invalid
        continue;
    }

    if (
        (!isset($prefixIndexes[0]) || !isset($prefixIndexes[1])) // We need at least 2 valid prefixes
        || !isset($suffixIndexes[count($chunks)-1])              // We need at least 1 valid suffix
        || max($prefixIndexes) > min($suffixIndexes)             // No prefix after the first suffix
        || count($suffixIndexes) >= count($prefixIndexes)
    ) {
        continue;
    }

    $ans++;
}
var_dump($ans);