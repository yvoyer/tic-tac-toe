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
        $this->display = $this->getMock('Star\TicTacToe\Display');

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
        $this->assertPlayerIsPartOfGame();

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

        $grid = $this->getMock(Grid::CLASS_NAME);
        $grid
            ->expects($this->once())
            ->method('play')
            ->with($cellId, $this->player1);

        $this->game = new Game($this->player1, $this->player2, $grid);
        $this->assertPlayerIsPartOfGame();

        $this->game->playTurn($this->player1, $cellId);
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

    private function assertPlayerIsPartOfGame()
    {
        $this->player1
            ->expects($this->any())
            ->method('equals')
            ->will($this->returnValue(true));
    }
}
 