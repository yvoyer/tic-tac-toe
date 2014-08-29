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

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $game;

    public function setUp()
    {
        $this->grid = $this->getMock(Grid::CLASS_NAME);

        $this->player1 = $this->getMockBuilder(Player::CLASS_NAME)->disableOriginalConstructor()->getMock();
        $this->player1
            ->expects($this->any())
            ->method('getToken')
            ->willReturn('X');

        $this->player2 = $this->getMockBuilder(Player::CLASS_NAME)->disableOriginalConstructor()->getMock();
        $this->player2
            ->expects($this->any())
            ->method('getToken')
            ->willReturn('O');

        $this->game = $this->getMockBuilder(Game::CLASS_NAME)->disableOriginalConstructor()->getMock();

        $this->result = new GameResult($this->grid, $this->player1, $this->player2, $this->game);
    }

    public function test_should_be_a_draw()
    {
        $this->assertGameIsFinished();
        $this->assertWinningTokenIsReturned('');

        $this->assertFalse($this->result->isWin());
        $this->assertTrue($this->result->isDraw());
    }

    public function test_should_player1_as_the_winner()
    {
        $this->assertGameIsFinished();
        $this->assertWinningTokenIsReturned('X');

        $this->assertTrue($this->result->isWin());
        $this->assertFalse($this->result->isDraw());
        $this->assertSame($this->player1, $this->result->getWinner());
    }

    public function test_should_player2_as_the_winner()
    {
        $this->assertGameIsFinished();
        $this->assertWinningTokenIsReturned('O');

        $this->assertTrue($this->result->isWin());
        $this->assertFalse($this->result->isDraw());
        $this->assertSame($this->player2, $this->result->getWinner());
    }

    /**
     * @expectedException        \RuntimeException
     * @expectedExceptionMessage The token 'E' is not owned by any player.
     */
    public function test_getWinner_should_throw_exception_when_token_not_owned_by_any_player()
    {
        $this->assertWinningTokenIsReturned('E');

        $this->assertNull($this->result->getWinner());
    }

    /**
     * @expectedException        \RuntimeException
     * @expectedExceptionMessage The token 'E' is not owned by any player.
     */
    public function test_isWin_should_throw_exception_when_token_not_owned_by_any_player()
    {
        $this->assertWinningTokenIsReturned('E');

        $this->assertFalse($this->result->isWin());
    }

    public function test_isDraw_should_not_be_a_draw_when_no_token_returned()
    {
        $this->assertGameIsFinished();
        $this->assertWinningTokenIsReturned('');

        $this->assertFalse($this->result->isWin());
        $this->assertTrue($this->result->isDraw());
        $this->assertNull($this->result->getWinner());
    }

    private function assertGameIsFinished()
    {
        $this->game
            ->expects($this->atLeastOnce())
            ->method('isFinished')
            ->will($this->returnValue(true));
    }

    private function assertWinningTokenIsReturned($token)
    {
        $this->grid
            ->expects($this->atLeastOnce())
            ->method('getWinningToken')
            ->willReturn($token);
    }
}
 