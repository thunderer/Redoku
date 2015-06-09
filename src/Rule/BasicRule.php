<?php
namespace Thunder\Redoku\Rule;

use Thunder\Redoku\Board;
use Thunder\Redoku\RuleInterface;

/**
 * Simplest rule: map possible digits in each field using line and cell rules
 * and search for those fields in which only one valid remains.
 *
 * @author Tomasz Kowalczyk <tomasz@kowalczyk.cc>
 */
final class BasicRule extends AbstractRule implements RuleInterface
    {
    public function process(Board $board)
        {
        $digits = $this->mapPossibleDigits($board);

        for($i = 0; $i < 9; $i++)
            {
            for($j = 0; $j < 9; $j++)
                {
                if($board->hasDigit($i, $j))
                    {
                    continue;
                    }
                if(count($digits[$i][$j]) === 1)
                    {
                    $board = $board->changeDigit($i, $j, intval(implode('', $digits[$i][$j])));
                    }
                }
            }

        return $board;
        }
    }
