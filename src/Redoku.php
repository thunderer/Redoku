<?php
namespace Thunder\Redoku;

final class Redoku
    {
    /** @var RuleInterface[] */
    private $rules = array();

    public function __construct()
        {
        }

    public function addRule(RuleInterface $rule)
        {
        $this->rules[] = $rule;
        }

    public function solve(Board $board)
        {
        $newBoard = clone $board;

        while(!$board->isSolved())
            {
            foreach($this->rules as $rule)
                {
                $newBoard = $rule->process($newBoard);
                }
            if($newBoard->equals($board))
                {
                break;
                }
            $board = $newBoard;
            }

        return $board;
        }
    }
