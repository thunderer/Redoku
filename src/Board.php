<?php
namespace Thunder\Redoku;

final class Board
    {
    private $digits = array();

    public function __construct(array $digits)
        {
        $this->digits = $digits;
        $this->isValid();
        }

    public static function fromString($string)
        {
        $lines = explode("\n", trim($string));
        if(count($lines) !== 9)
            {
            throw new \InvalidArgumentException('Required 9 lines!');
            }

        $digits = array();
        foreach($lines as $line)
            {
            $lineDigits = array_map(function($digit) {
                $value = intval($digit);

                return $value >= 1 && $value <= 9 ? $value : null;
                }, str_split(trim($line), 1));
            if(count($lineDigits) !== 9)
                {
                throw new \InvalidArgumentException('Every line must contain 9 digits!');
                }
            $digits[] = $lineDigits;
            }

        return new self($digits);
        }

    public function hasDigit($x, $y)
        {
        return $this->digits[$x][$y] !== null;
        }

    public function getDigit($x, $y)
        {
        return $this->digits[$x][$y];
        }

    public function isSolved()
        {
        return $this->countEmpty() === 0;
        }

    public function getLineDigits($n)
        {
        return array_filter($this->digits[$n]);
        }

    public function getColumnDigits($n)
        {
        $digits = array();
        for($i = 0; $i < 9; $i++)
            {
            $digits[] = $this->digits[$i][$n];
            }

        return array_filter($digits);
        }

    public function changeDigit($x, $y, $value)
        {
        if($value < 1 || $value > 9)
            {
            throw new \InvalidArgumentException('Required number between 1 and 9!');
            }

        $digits = $this->digits;
        $digits[$x][$y] = $value;

        return new self($digits);
        }

    public function getCellDigitsByDigit($x, $y)
        {
        $x = intval(floor($x / 3) * 3);
        $y = intval(floor($y / 3) * 3);
        $digits = array();

        for($i = $x; $i < $x + 3; $i++)
            {
            for($j = $y; $j < $y + 3; $j++)
                {
                $digits[] = $this->digits[$i][$j];
                }
            }

        return array_filter($digits);
        }

    private function isValid()
        {
        for($i = 0; $i < 9; $i++)
            {
            $vDigits = array();
            $hDigits = array();
            for($j = 0; $j < 9; $j++)
                {
                if($this->digits[$i][$j] !== null && in_array($this->digits[$i][$j], $vDigits))
                    {
                    throw new \RuntimeException(sprintf('Invalid board at [%s,%s] symbol %s!', $i, $j, $this->digits[$i][$j]));
                    }
                $vDigits[] = $this->digits[$i][$j];
                if($this->digits[$j][$i] !== null && in_array($this->digits[$j][$i], $hDigits))
                    {
                    throw new \RuntimeException(sprintf('Invalid board at [%s,%s] symbol %s!', $j, $i, $this->digits[$j][$i]));
                    }
                $hDigits[] = $this->digits[$j][$i];
                }
            }

        return true;
        }

    public function equals(Board $board)
        {
        $lineIndex = 0;

        foreach($this->digits as $line)
            {
            $index = 0;
            foreach($line as $digit)
                {
                if($board->getDigit($lineIndex, $index) !== $digit)
                    {
                    return false;
                    }
                $index++;
                }
            $lineIndex++;
            }

        return true;
        }

    public function render()
        {
        echo '+---+---+---+'."\n";
        $lineIndex = 0;
        foreach($this->digits as $line)
            {
            echo '|';
            $index = 0;
            foreach($line as $digit)
                {
                echo ($digit === null ? '.' : $digit).($index > 0 && $index % 3 == 2 ? '|' : '');
                $index++;
                }
            echo "\n".($lineIndex > 0 && $lineIndex % 3 == 2 ? '+---+---+---+'."\n" : '');
            $lineIndex++;
            }
        }

    private function countEmpty()
        {
        $empty = 0;
        foreach($this->digits as $line)
            {
            foreach($line as $digit)
                {
                if($digit === null)
                    {
                    $empty++;
                    }
                }
            }

        return $empty;
        }
    }
