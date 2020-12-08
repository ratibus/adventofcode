<?php

// Solved in 12 minutes
$inputFile = __DIR__.'/input.txt';

$codeInstructions = getCodeInstructions($inputFile);

$runCode = runCode($codeInstructions);
var_dump($runCode);

function runCode($codeInstructions) {

    $acc = 0;
    $infiniteLoop = false;
    $operationIndex = 0;
    $runIndexes = [];
    while ($operationIndex < count($codeInstructions)) {

        if (isset($runIndexes[$operationIndex])) {
            $infiniteLoop = true;
            break;
        }
        $runIndexes[$operationIndex] = $operationIndex;

        $operationToRun = $codeInstructions[$operationIndex];

        switch ($operationToRun['operation']) {
            case 'nop':
                $operationIndex++;
                break;
            case 'acc':
                $acc += $operationToRun['value'];
                $operationIndex++;
                break;
            case 'jmp':
                $operationIndex += $operationToRun['value'];
                break;
            default:
                throw new InvalidArgumentException("Operation not supported: ".$operationToRun['operation']);
                break;
        }
    }
    return ['acc' => $acc, 'infinite_loop' => $infiniteLoop];
}

function getCodeInstructions($inputFile) {

    $codeInstructions = [];

    foreach (file($inputFile, FILE_IGNORE_NEW_LINES) as $line) {
        $line = trim($line);

        list($operation, $value) = explode(' ', $line);

        $codeInstructions[] = [
            'operation' => $operation,
            'value' => $value,
        ];
    }

    return $codeInstructions;
}
