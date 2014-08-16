<?php
/**
 * This file is part of the tic-tac-toe project.
 * 
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\TicTacToe;

use Star\TicTacToe\Display\ConsoleDisplay;
use Star\TicTacToe\Grid\ColumnRowGrid;
use Star\TicTacToe\Id\ColumnRowId;
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

        $game = new Game($player1, $player2, new ColumnRowGrid());
        $game->playTurn($player1, new ColumnRowId('a', 1));
        $game->playTurn($player2, new ColumnRowId('a', 2));
        $game->playTurn($player1, new ColumnRowId('a', 3));
        $game->playTurn($player2, new ColumnRowId('b', 1));
        $game->playTurn($player1, new ColumnRowId('c', 3));
        $game->playTurn($player2, new ColumnRowId('b', 3));
        $game->playTurn($player1, new ColumnRowId('c', 1));
        $game->playTurn($player2, new ColumnRowId('c', 2));

        $output = new BufferedOutput();
        $game->render(new ConsoleDisplay($output));
        $expected = <<<Expected
-------------
| X | O | X |
| O |   | O |
| X | O | X |
-------------

Expected;
        $this->assertEquals($expected, $output->fetch());
    }
}