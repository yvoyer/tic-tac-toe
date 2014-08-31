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
 *
 * @covers Star\TicTacToe\Game
 * @uses Star\TicTacToe\Player
 * @uses Star\TicTacToe\GameResult
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
        $this->assertGameIsStarted();
        $this->game->playTurn($this->getMockCellId());
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
        $this->assertGameIsStarted();
        $this->grid
            ->expects($this->once())
            ->method('play')
            ->with($this->cellId, $this->player1);

        $this->assertPlayerOneIsPartOfGame();

        $this->game->playTurn($this->cellId);
    }

    /**
     * @expectedException        \RuntimeException
     * @expectedExceptionMessage The game is finished since the grid has a line.
     */
    public function test_should_throw_exception_when_a_player_has_a_line()
    {
        $this->assertGameIsStarted();
        $this->grid
            ->expects($this->once())
            ->method('hasLine')
            ->will($this->returnValue(true));
        $this->assertPlayerOneIsPartOfGame();

        $this->assertInstanceOf(Result::INTERFACE_NAME, $this->game->playTurn($this->getMockCellId()));
    }

    public function test_should_set_player_one_as_first_player()
    {
        $this->assertNull($this->game->getCurrentPlayer());
        $this->assertGameIsStarted();
        $this->assertPlayerOneIsPartOfGame();
        $this->assertSame($this->player1, $this->game->getCurrentPlayer());
    }

    public function test_a_full_line_should_return_consider_the_game_finished()
    {
        $this->assertFalse($this->game->isFinished());
        $this->grid
            ->expects($this->once())
            ->method('hasLine')
            ->will($this->returnValue(true));

        $this->assertTrue($this->game->isFinished());
    }

    public function test_a_full_grid_should_return_consider_the_game_finished()
    {
        $this->assertFalse($this->game->isFinished());
        $this->grid
            ->expects($this->once())
            ->method('isFull')
            ->will($this->returnValue(true));

        $this->assertTrue($this->game->isFinished());
    }

    public function test_should_switch_player_when_player_played()
    {
        $this->player1 = new Player('1', 'p1');
        $this->player2 = new Player('2', 'p2');
        $this->game = new Game($this->player1, $this->player2, $this->grid);
        $this->assertGameIsStarted();

        $this->assertSame($this->player1, $this->game->getCurrentPlayer());
        $this->game->playTurn($this->cellId);
        $this->assertSame($this->player2, $this->game->getCurrentPlayer());
        $this->game->playTurn($this->cellId);
        $this->assertSame($this->player1, $this->game->getCurrentPlayer());
        $this->game->playTurn($this->cellId);
        $this->assertSame($this->player2, $this->game->getCurrentPlayer());
        $this->game->playTurn($this->cellId);
        $this->assertSame($this->player1, $this->game->getCurrentPlayer());
    }

    /**
     * @expectedException        \RuntimeException
     * @expectedExceptionMessage The game is not yet started.
     */
    public function test_should_throw_exception_when_the_game_is_not_started()
    {
        $this->game->playTurn($this->cellId);
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
        return $this->getMock(CellId::INTERFACE_NAME);
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

    private function assertPlayerTwoIsPartOfGame()
    {
        $this->player2
            ->expects($this->any())
            ->method('equals')
            ->will($this->returnValue(true));
    }

    private function assertGameIsStarted()
    {
        $this->game->start($this->player1);
    }

    private function assertGameIsFinished()
    {
        $this->grid
            ->expects($this->atLeastOnce())
            ->method('hasLine')
            ->will($this->returnValue(true));
    }
}
 