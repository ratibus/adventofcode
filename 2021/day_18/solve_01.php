<?php

// Solved in few hours

$inputFile = __DIR__ . '/input_test.txt';
$inputFile = __DIR__ . '/input.txt';

foreach (file($inputFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
    if (!isset($number)) {
        $number = $line;
        continue;
    }
    $number = add($number, $line);
    $number = reduce($number);
}
var_dump(magnitude($number));
exit;

function reduce($number) {
    while (true) {
        $newNumber1 = explod($number);
        if ($newNumber1 !== $number) {
            $number = $newNumber1;
            continue;
        }
        $newNumber2 = split($newNumber1);
        if ($newNumber2 !== $newNumber1) {
            $number = $newNumber2;
            continue;
        }
        break;
    }
    return $number;
}

function add($n1, $n2) {
    return sprintf('[%s,%s]', $n1, $n2);
}

function explod($number) {
    $nb = preg_match_all('/\[\d+,\d+\]/', $number, $matches, PREG_OFFSET_CAPTURE);
    if (!$nb) {
        return $number;
    }

    foreach ($matches[0] as list($pair, $offset)) {
        $charsCounts = count_chars(substr($number, 0, $offset), 1);
        $depth = ($charsCounts[91] ?? 0) - ($charsCounts[93] ?? 0); // 91 is [ and 93 is ] is ASCII
        if ($depth < 4) { // not a valid pair
            continue;
        }

        list($left, $right) = explode(',', trim($pair, '[]'));

        $numberLeftPart = substr($number, 0, $offset);
        $numberRightPart = substr($number, $offset + strlen($pair));

        // Add left to the left part (the trick is to reverse the string)
        $numberLeftPart = strrev(preg_replace_callback('/\d+/', function($matches) use ($left) {
            return strrev($left+strrev($matches[0]));
        }, strrev($numberLeftPart), 1));

        // Add right to the right part
        $numberRightPart = preg_replace_callback('/\d+/', function($matches) use ($right) {
            return $right+$matches[0];
        }, $numberRightPart, 1);

        return sprintf('%s0%s', $numberLeftPart, $numberRightPart); // parts glueing and pair replaced by 0
    }

    return $number;
}

function magnitude($number) {
    do {
        $number = preg_replace_callback('/\[\d+,\d+\]/', function($matches) {
            list($left, $right) = explode(',', trim($matches[0], '[]'));
            return 3*$left + 2*$right;
        }, $number, -1, $count);
    } while ($count > 0);
    return $number;
}

function split($number) {
    return preg_replace_callback('/\d{2}/', function($matches) {
        $left = floor($matches[0]/2);
        $right = $matches[0] - $left;
        return add($left, $right);
    }, $number, 1);
}

// Tests
$splitExamples = [
    '[[[[0,7],4],[15,[0,13]]],[1,1]]' => '[[[[0,7],4],[[7,8],[0,13]]],[1,1]]',
    '[[[[0,7],4],[[7,8],[0,13]]],[1,1]]' => '[[[[0,7],4],[[7,8],[0,[6,7]]]],[1,1]]',
];

$explodeExamples = [
    '[[[[[4,3],4],4],[7,[[8,4],9]]],[1,1]]' => '[[[[0,7],4],[7,[[8,4],9]]],[1,1]]',
    '[[[[[9,8],1],2],3],4]' => '[[[[0,9],2],3],4]',
    '[7,[6,[5,[4,[3,2]]]]]' => '[7,[6,[5,[7,0]]]]',
    '[[6,[5,[4,[3,2]]]],1]' => '[[6,[5,[7,0]]],3]',
    '[[3,[2,[1,[7,3]]]],[6,[5,[4,[3,2]]]]]' => '[[3,[2,[8,0]]],[9,[5,[4,[3,2]]]]]',
    '[[3,[2,[8,0]]],[9,[5,[4,[3,2]]]]]' => '[[3,[2,[8,0]]],[9,[5,[7,0]]]]',
    '[[[[0,7],4],[7,[[8,4],9]]],[1,1]]' => '[[[[0,7],4],[15,[0,13]]],[1,1]]',
    '[[[[0,7],4],[[7,8],[0,[6,7]]]],[1,1]]' => '[[[[0,7],4],[[7,8],[6,0]]],[8,1]]',
];

$magnitudesExamples = [
    '[[1,2],[[3,4],5]]' => 143,
    '[[[[0,7],4],[[7,8],[6,0]]],[8,1]]' => 1384,
    '[[[[1,1],[2,2]],[3,3]],[4,4]]' => 445,
    '[[[[3,0],[5,3]],[4,4]],[5,5]]' => 791,
    '[[[[5,0],[7,4]],[5,5]],[6,6]]' => 1137,
    '[[[[8,7],[7,7]],[[8,6],[7,7]]],[[[0,7],[6,6]],[8,7]]]' => 3488,
];

$reduceExamples = [
    '[[[[4,3],4],4],[7,[[8,4],9]]]+[1,1]' => '[[[[0,7],4],[[7,8],[6,0]]],[8,1]]',
    '[[[0,[4,5]],[0,0]],[[[4,5],[2,6]],[9,5]]]+[7,[[[3,7],[4,3]],[[6,3],[8,8]]]]' => '[[[[4,0],[5,4]],[[7,7],[6,0]]],[[8,[7,7]],[[7,9],[5,0]]]]',
    '[[[[4,0],[5,4]],[[7,7],[6,0]]],[[8,[7,7]],[[7,9],[5,0]]]]+[[2,[[0,8],[3,4]]],[[[6,7],1],[7,[1,6]]]]' => '[[[[6,7],[6,7]],[[7,7],[0,7]]],[[[8,7],[7,7]],[[8,8],[8,0]]]]',
    '[[[[6,7],[6,7]],[[7,7],[0,7]]],[[[8,7],[7,7]],[[8,8],[8,0]]]]+[[[[2,4],7],[6,[0,5]]],[[[6,8],[2,8]],[[2,1],[4,5]]]]' => '[[[[7,0],[7,7]],[[7,7],[7,8]]],[[[7,7],[8,8]],[[7,7],[8,7]]]]',
    '[[[[7,0],[7,7]],[[7,7],[7,8]]],[[[7,7],[8,8]],[[7,7],[8,7]]]]+[7,[5,[[3,8],[1,4]]]]' => '[[[[7,7],[7,8]],[[9,5],[8,7]]],[[[6,8],[0,8]],[[9,9],[9,0]]]]',
    '[[[[7,7],[7,8]],[[9,5],[8,7]]],[[[6,8],[0,8]],[[9,9],[9,0]]]]+[[2,[2,2]],[8,[8,1]]]' => '[[[[6,6],[6,6]],[[6,0],[6,7]]],[[[7,7],[8,9]],[8,[8,1]]]]',
    '[[[[6,6],[6,6]],[[6,0],[6,7]]],[[[7,7],[8,9]],[8,[8,1]]]]+[2,9]' => '[[[[6,6],[7,7]],[[0,7],[7,7]]],[[[5,5],[5,6]],9]]',
    '[[[[6,6],[7,7]],[[0,7],[7,7]]],[[[5,5],[5,6]],9]]+[1,[[[9,3],9],[[9,0],[0,7]]]]' => '[[[[7,8],[6,7]],[[6,8],[0,8]]],[[[7,7],[5,0]],[[5,5],[5,6]]]]',
    '[[[[7,8],[6,7]],[[6,8],[0,8]]],[[[7,7],[5,0]],[[5,5],[5,6]]]]+[[[5,[7,4]],7],1]' => '[[[[7,7],[7,7]],[[8,7],[8,7]]],[[[7,0],[7,7]],9]]',
    '[[[[7,7],[7,7]],[[8,7],[8,7]]],[[[7,0],[7,7]],9]]+[[[[4,2],2],6],[8,7]]' => '[[[[8,7],[7,7]],[[8,6],[7,7]]],[[[0,7],[6,6]],[8,7]]]',
];

foreach ($reduceExamples as $n1 => $n2) {
    list($a, $b) = explode('+', $n1);
    $addition = add($a, $b);

    $n3 = reduce($addition);
    if ($n3 !== $n2) {
        printf("Reduce failed for %s: %s expected, got %s\n", $n1, $n2, $n3);
        break;
    } else {
        printf("Reduce for %s: OK \o/\n", $n1);
    }
}
foreach ($explodeExamples as $n1 => $n2) {
    $n3 = explod($n1);
    if ($n3 !== $n2) {
        printf("Explode failed for %s: %s expected, got %s\n", $n1, $n2, $n3);
        break;
    } else {
        printf("Explode for %s: OK \o/\n", $n1);
    }
}
foreach ($splitExamples as $n1 => $n2) {
    $ns = split($n1);
    if ($ns !== $n2) {
        printf("Split failed for %s: %s expected, got %s\n", $n1, $n2, $ns);
        break;
    } else {
        printf("Split for %s: OK \o/\n", $n1);
    }
}
foreach ($magnitudesExamples as $n1 => $n2) {
    $ns = magnitude($n1);
    if ($ns != $n2) {
        printf("Magnitude failed for %s: %d expected, got %d\n", $n1, $n2, $ns);
        break;
    } else {
        printf("Magnitude for %s: OK \o/\n", $n1);
    }
}
