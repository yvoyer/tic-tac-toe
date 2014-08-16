<?php
/**
 * This file is part of the tic-tac-toe project.
 * 
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\TicTacToe;

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

    public function setUp()
    {
        $this->player1 = $this->getMockPlayer();
        $this->player2 = $this->getMockPlayer();
        $this->display = $this->getMock('Star\TicTacToe\Display\Display');

        $this->game = new Game($this->player1, $this->player2);
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

        $grid = $this->game->playTurn($this->player1, new CellId('b', 2));
        $this->assertInstanceOf(Grid::CLASS_NAME, $grid);
    }

    /**
     * @dataProvider provideDataToDisplay
     */
    public function test_should_render_using_the_display($method)
    {
        $this->display
            ->expects($this->once())
            ->method($method);

        $this->game->render($this->display);
    }

    public function provideDataToDisplay()
    {
        return array(
            array('setA1'),
            array('setA2'),
            array('setA3'),
            array('setB1'),
            array('setB2'),
            array('setB3'),
            array('setC1'),
            array('setC2'),
            array('setC3'),
            array('render'),
        );
    }

    public function test_should_play_turn_on_grid()
    {
        $cellId = new CellId('b', 2);

        $grid = $this->getMockGrid();
        $grid
            ->expects($this->once())
            ->method('play')
            ->with($cellId, $this->player1);

        $this->game = new Game($this->player1, $this->player2, $grid);
        $this->assertPlayerOneIsPartOfGame();

        $this->game->playTurn($this->player1, $cellId);
    }

    /**
     * @expectedException        \RuntimeException
     * @expectedExceptionMessage The game is finished since the grid has a line.
     */
    public function test_should_throw_exception_when_a_player_has_a_line()
    {
        $grid = $this->getMockGrid();
        $grid
            ->expects($this->once())
            ->method('hasLine')
            ->will($this->returnValue(true));
        $this->assertPlayerOneIsPartOfGame();

        $this->game = new Game($this->player1, $this->player2, $grid);
        $this->game->playTurn($this->player1, $this->getMockCellId());
    }

    /**
     * @expectedException        \RuntimeException
     * @expectedExceptionMessage You already played, it should be the other player turn.
     */
    public function test_should_throw_exception_when_player_are_not_playing_in_the_right_order()
    {
        $this->assertPlayerOneIsPartOfGame();

        $this->game->playTurn($this->player1, new CellId('a', 1));
        $this->game->playTurn($this->player1, new CellId('a', 2));
    }

    public function test_should_set_player_one_as_first_player()
    {
        $this->assertPlayerOneIsPartOfGame();
        $this->assertNull($this->game->getCurrentPlayer());
        $this->game->playTurn($this->player1, new CellId('a', 1));
        $this->assertSame($this->player1, $this->game->getCurrentPlayer());
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
        return $this->getMockBuilder(CellId::CLASS_NAME)->disableOriginalConstructor()->getMock();
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
}
 