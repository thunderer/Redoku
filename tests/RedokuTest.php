<?php
namespace Thunder\Redoku\Tests;

use Thunder\Redoku\Board;
use Thunder\Redoku\Redoku;
use Thunder\Redoku\Rule\LineRule;
use Thunder\Redoku\Rule\BasicRule;

final class RedokuTest extends \PHPUnit_Framework_TestCase
    {
    /**
     * @dataProvider provideBoards
     */
    public function testSolve($file)
        {
        $parts = explode('---', file_get_contents(__DIR__.'/fixtures/sudoku/'.$file), 2);

        $redoku = new Redoku();
        $redoku->addRule(new BasicRule());
        $redoku->addRule(new LineRule());

        $board = $redoku->solve(Board::fromString($parts[0]));

        $this->assertTrue($board->equals(Board::fromString($parts[1])));
        }

    public function provideBoards()
        {
        return array(
            array('example0.txt'),
            array('example1.txt'),
            array('example2.txt'),
            );
        }
    }
