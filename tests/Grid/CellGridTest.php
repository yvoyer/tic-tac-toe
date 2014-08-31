<?php
/**
 * This file is part of the tic-tac-toe project.
 * 
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\TicTacToe\Grid;

use Star\TicTacToe\Id\CellId;
use Star\TicTacToe\Id\ColumnRowId;
use Star\TicTacToe\Player;

/**
 * Class ColumnRowGridTest
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\TicTacToe\Grid
 *
 * @covers Star\TicTacToe\Grid\CellGrid
 * @uses Star\TicTacToe\Id\ColumnRowId
 */
class CellGridTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CellGrid|\PHPUnit_Framework_MockObject_MockObject
     */
    private $grid;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $player;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $display;

    public function setUp()
    {
        $this->player = $this->getMockPlayer();
        $this->display = $this->getMock('Star\TicTacToe\Display\Display');

        $this->grid = $this->getMockForAbstractClass('Star\TicTacToe\Grid\CellGrid', array(), '', false);
    }

    /**
     * @expectedException        \InvalidArgumentException
     * @expectedExceptionMessage The cell id 'r,4' is not found.
     */
    public function test_should_throw_exception_when_not_found_id()
    {
        $this->grid->play(new ColumnRowId('r', 4), $this->player);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockPlayer()
    {
        return $this->getMockBuilder(Player::CLASS_NAME)->disableOriginalConstructor()->getMock();
    }
}
