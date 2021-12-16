<?php

// Solved in 2h45 minutes

$inputFile = __DIR__ . '/input.txt';

$versionsSum = 0;
$binStr = decodeHex(file_get_contents($inputFile));
decodePacket($binStr, null, $versionsSum);
var_dump($versionsSum);

function decodeHex($hexStr) {
    $binStr = '';
    foreach (str_split($hexStr) as $char) {
        $binChar = str_pad(base_convert($char, 16, 2), 4, 0, STR_PAD_LEFT);
        $binStr .= $binChar;
    }
    return $binStr;
}

function decodePacket($binStr, $limit, &$versionsSum) {

    $p = 0;
    $nbPackets = 0;
    while ($p < strlen($binStr)) {

        if (str_replace('0', '', substr($binStr, $p))==='') {
            break;
        }

        if ($limit !== null && $limit == $nbPackets) {
            break;
        }

        $version = base_convert(substr($binStr, $p, 3), 2, 10);
        $p += 3;
        $packetTypeId = base_convert(substr($binStr, $p, 3), 2, 10);
        $p += 3;

        $versionsSum += $version;

        if ($packetTypeId == 4) {

            $values = [];
            while (true) {
                $sub = substr($binStr, $p, 5);
                $p += 5;
                $values[] = substr($sub, -4);
                if (substr($sub, 0, 1) == 0) {
                    break;
                }
            }

            $literal = base_convert(implode('', $values), 2, 10);

        } else {

            $lengthTypeId = substr($binStr, $p, 1);
            $p++;

            if ($lengthTypeId == 0) {
                $length = base_convert(substr($binStr, $p, 15), 2, 10);
                $p += 15;
                $subPackets = substr($binStr, $p, $length);
                $p += $length;
                decodePacket($subPackets, null, $versionsSum);

            } elseif ($lengthTypeId == 1) {
                $nbSubPackets = base_convert(substr($binStr, $p, 11), 2, 10);
                $p += 11;

                $subPackets = substr($binStr, $p);

                $bitsRead = decodePacket($subPackets, $nbSubPackets, $versionsSum);
                $p += $bitsRead;
            }
        }
        $nbPackets++;
    }
    return $p; // readBits
}
