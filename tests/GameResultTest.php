<?php
/**
 * This file is part of the tic-tac-toe project.
 * 
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\TicTacToe;

use Star\TicTacToe\Grid\Grid;

/**
 * Class GameResultTest
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\TicTacToe
 *
 * @covers Star\TicTacToe\GameResult
 */
class GameResultTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GameResult
     */
    private $result;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $grid;

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
        $this->grid = $this->getMock(Grid::CLASS_NAME);
        $this->player1 = $this->getMockBuilder(Player::CLASS_NAME)->disableOriginalConstructor()->getMock();
        $this->player2 = $this->getMockBuilder(Player::CLASS_NAME)->disableOriginalConstructor()->getMock();

        $this->result = new GameResult($this->grid, $this->player1, $this->player2);
    }

    public function test_should_be_a_draw()
    {
        $this->assertFalse($this->result->isWin());
        $this->assertTrue($this->result->isDraw());
    }

    public function test_should_be_a_win()
    {
        $this->grid
            ->expects($this->atLeastOnce())
            ->method('hasLine')
            ->will($this->returnValue(true));

        $this->assertTrue($this->result->isWin());
        $this->assertFalse($this->result->isDraw());
    }

    public function test_should_player1_as_the_winner()
    {
        $this->player1
            ->expects($this->once())
            ->method('getToken')
            ->willReturn('X');

        $this->grid
            ->expects($this->once())
            ->method('getWinningToken')
            ->willReturn('X');

        $this->assertSame($this->player1, $this->result->getWinner());
    }

    public function test_should_player2_as_the_winner()
    {
        $this->player2
            ->expects($this->once())
            ->method('getToken')
            ->willReturn('O');

        $this->grid
            ->expects($this->once())
            ->method('getWinningToken')
            ->willReturn('O');

        $this->assertSame($this->player2, $this->result->getWinner());
    }

    public function test_should_return_no_winner()
    {
        $this->player1
            ->expects($this->once())
            ->method('getToken')
            ->willReturn('X');
        $this->player2
            ->expects($this->once())
            ->method('getToken')
            ->willReturn('O');

        $this->assertNull($this->result->getWinner());
    }
}
 