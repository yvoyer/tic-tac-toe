<?php
/**
 * This file is part of the tic-tac-toe project.
 * 
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\TicTacToe;

use Star\TicTacToe\Grid\Grid;
use Star\TicTacToe\Id\CellId;

/**
 * Class GameTest
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\TicTacToe
 */
class GameTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Game
     */
    private $game;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $display;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $player1;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $player2;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $cellId;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $grid;

    public function setUp()
    {
        $this->player1 = $this->getMockPlayer();
        $this->player2 = $this->getMockPlayer();
        $this->display = $this->getMock('Star\TicTacToe\Display\Display');
        $this->cellId = $this->getMockCellId();
        $this->grid = $this->getMockGrid();

        $this->game = new Game($this->player1, $this->player2, $this->grid);
    }

    /**
     * @expectedException        \InvalidArgumentException
     * @expectedExceptionMessage The player is not part of the game.
     */
    public function test_should_throw_exception_when_player_is_not_part_of_game()
    {
        $this->game->playTurn($this->getMockPlayer(), $this->getMockCellId());
    }

    public function test_should_return_a_completed_grid()
    {
        $this->assertPlayerOneIsPartOfGame();
        $this->assertInstanceOf(Grid::CLASS_NAME, $this->game->playTurn($this->player1, $this->cellId));
    }

    public function test_should_render_using_the_display()
    {
        $this->grid
            ->expects($this->once())
            ->method('render')
            ->with($this->display);

        $this->game->render($this->display);
    }

    public function test_should_play_turn_on_grid()
    {
        $this->grid
            ->expects($this->once())
            ->method('play')
            ->with($this->cellId, $this->player1);

        $this->assertPlayerOneIsPartOfGame();

        $this->game->playTurn($this->player1, $this->cellId);
    }

    /**
     * @expectedException        \RuntimeException
     * @expectedExceptionMessage The game is finished since the grid has a line.
     */
    public function test_should_throw_exception_when_a_player_has_a_line()
    {
        $this->grid
            ->expects($this->once())
            ->method('hasLine')
            ->will($this->returnValue(true));
        $this->assertPlayerOneIsPartOfGame();

        $this->game->playTurn($this->player1, $this->getMockCellId());
    }

    /**
     * @expectedException        \RuntimeException
     * @expectedExceptionMessage You already played, it should be the other player turn.
     */
    public function test_should_throw_exception_when_player_are_not_playing_in_the_right_order()
    {
        $this->assertPlayerOneIsPartOfGame();

        $this->game->playTurn($this->player1, $this->cellId);
        $this->game->playTurn($this->player1, $this->cellId);
    }

    public function test_should_set_player_one_as_first_player()
    {
        $this->assertPlayerOneIsPartOfGame();
        $this->assertNull($this->game->getCurrentPlayer());
        $this->game->playTurn($this->player1, $this->cellId);
        $this->assertSame($this->player1, $this->game->getCurrentPlayer());
    }

    public function test_should_return_whether_the_game_is_finished()
    {
        $this->assertFalse($this->game->isFinished());

        $this->grid
            ->expects($this->once())
            ->method('hasLine')
            ->will($this->returnValue(true));
        $this->assertTrue($this->game->isFinished());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockGrid()
    {
        return $this->getMock(Grid::CLASS_NAME);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockCellId()
    {
        return $this->getMock(CellId::CLASS_NAME);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockPlayer()
    {
        return $this->getMockBuilder(Player::CLASS_NAME)->disableOriginalConstructor()->getMock();
    }

    private function assertPlayerOneIsPartOfGame()
    {
        $this->player1
            ->expects($this->any())
            ->method('equals')
            ->will($this->returnValue(true));
    }
}
 