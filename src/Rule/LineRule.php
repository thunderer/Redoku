<?php
namespace Thunder\Redoku\Rule;

use Thunder\Redoku\Board;
use Thunder\Redoku\RuleInterface;

/**
 * Map possible digits in 3x3 cells using line and cell rules and search for
 * digits that can be placed in only one cell field.
 *
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class LineRule extends AbstractRule implements RuleInterface
    {
    public function process(Board $board)
        {
        $digits = $this->mapPossibleDigits($board);

        for($i = 0; $i < 3; $i++)
            {
            for($j = 0; $j < 3; $j++)
                {
                $cellDigits = $this->mapCellDigits($i, $j, $board, $digits);
                foreach($cellDigits as $digit => $data)
                    {
                    if(1 !== $data['count'] || $board->hasDigit($data['x'], $data['y']))
                        {
                        continue;
                        }
                    $board = $board->changeDigit($data['x'], $data['y'], $digit);
                    }
                }
            }

        return $board;
        }

    private function mapCellDigits($i, $j, Board $board, array $digits)
        {
        $cellDigits = array();

        for($x = $i * 3; $x < $i * 3 + 3; $x++)
            {
            for($y = $j * 3; $y < $j * 3 + 3; $y++)
                {
                if($board->hasDigit($x, $y))
                    {
                    continue;
                    }
                foreach($digits[$x][$y] as $digit)
                    {
                    if(!array_key_exists($digit, $cellDigits))
                        {
                        $cellDigits[$digit] = array(
                            'x' => $x,
                            'y' => $y,
                            'count' => 0,
                            );
                        }
                    $cellDigits[$digit]['count']++;
                    }
                }
            }

        return $cellDigits;
        }
    }
