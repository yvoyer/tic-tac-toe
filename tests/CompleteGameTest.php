<?php
/**
 * This file is part of the tic-tac-toe project.
 * 
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\TicTacToe;

use Star\TicTacToe\Display\ConsoleDisplay;
use Star\TicTacToe\Grid\ColumnRowGrid;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\StreamOutput;

/**
 * Class CompleteGameTest
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\TicTacToe
 */
class CompleteGameTest extends \PHPUnit_Framework_TestCase
{
    public function test_play_a_full_game()
    {
        $player1 = new Player('X', 'player 1');
        $player2 = new Player('O', 'player 2');

        $grid = new ColumnRowGrid();
        $game = new Game($player1, $player2, $grid);
        $game->start($player1);
        $game->playTurn($grid->createId('a,1'));
        $game->playTurn($grid->createId('a,2'));
        $game->playTurn($grid->createId('a,3'));
        $game->playTurn($grid->createId('b,1'));
        $game->playTurn($grid->createId('c,3'));
        $game->playTurn($grid->createId('b,3'));
        $game->playTurn($grid->createId('c,1'));
        $game->playTurn($grid->createId('c,2'));

        $output = new BufferedOutput();
        $game->render(new ConsoleDisplay($output));
        $expected = <<<Expected
 X | O | X
-----------
 O |   | O
-----------
 X | O | X

Expected;
        $this->assertEquals($expected, $output->fetch());
    }
}