<?php
namespace Thunder\Redoku;

interface RuleInterface
    {
    /**
     * @param Board $board
     *
     * @return Board
     */
    public function process(Board $board);
    }
