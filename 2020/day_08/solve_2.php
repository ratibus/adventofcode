<?php

// Solved in 9 minutes
$inputFile = __DIR__.'/input.txt';

$codeInstructions = getCodeInstructions($inputFile);

for ($flipIndex = 0; $flipIndex < count($codeInstructions); $flipIndex++) {
    $runCode = runCode($codeInstructions, $flipIndex);
    if (!$runCode['infinite_loop']) {
        printf("Flip index %d worked !!!", $flipIndex);
        break;
    }
}
var_dump($runCode);

function runCode($codeInstructions, $flipIndex = null) {

    if (null !== $flipIndex) {
        if ($codeInstructions[$flipIndex]['operation'] === 'nop') {
            $codeInstructions[$flipIndex]['operation'] = 'jmp';
        } elseif ($codeInstructions[$flipIndex]['operation'] === 'jmp') {
            $codeInstructions[$flipIndex]['operation'] = 'nop';
        }
    }

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