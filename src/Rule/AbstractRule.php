<?php
namespace Thunder\Redoku\Rule;

use Thunder\Redoku\Board;

abstract class AbstractRule
    {
    protected function mapPossibleDigits(Board $board)
        {
        $allowedDigits = range(1, 9, 1);
        $digits = array();

        for($i = 0; $i < 9; $i++)
            {
            for($j = 0; $j < 9; $j++)
                {
                if($board->hasDigit($i, $j))
                    {
                    continue;
                    }
                $digits[$i][$j] = array_diff($allowedDigits, array_unique(array_filter(array_merge(
                    $board->getLineDigits($i),
                    $board->getColumnDigits($j),
                    $board->getCellDigitsByDigit($i, $j)
                    ))));
                }
            }

        return $digits;
        }

    protected function renderHelper(Board $board, array $digits)
        {
        $lineIndex = 0;
        echo '+'.str_pad('', 9 * 9 + 2, '-').'+'."\n";
        for($i = 0; $i < 9; $i++)
            {
            $index = 0;
            echo '|';
            for($j = 0; $j < 9; $j++)
                {
                $xxx = $board->hasDigit($i, $j)
                    ? 'X'
                    : implode('', isset($digits[$i][$j]) ? $digits[$i][$j] : array());
                echo sprintf('%9s', $xxx).($index > 0 && $index % 3 == 2 ? '|' : '');
                $index++;
                }
            echo ($lineIndex > 0 && $lineIndex % 3 == 2 ? "\n+".str_pad('', 9 * 9 + 2, '-').'+' : '')."\n";
            $lineIndex++;
            }
        }
    }
