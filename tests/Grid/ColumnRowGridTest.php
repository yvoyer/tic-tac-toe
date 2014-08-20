<?php
/**
 * This file is part of the tic-tac-toe project.
 * 
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\TicTacToe\Grid;

use Star\TicTacToe\Id\ColumnRowId;
use Star\TicTacToe\Player;

/**
 * Class ColumnRowGridTest
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\TicTacToe\Grid
 *
 * @covers Star\TicTacToe\Grid\ColumnRowGrid
 * @uses Star\TicTacToe\Id\ColumnRowId
 */
class ColumnRowGridTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ColumnRowGrid
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

        $this->grid = new ColumnRowGrid();
    }

    public function test_should_put_the_player_token_on_cell()
    {
        $this->player
            ->expects($this->once())
            ->method('getToken')
            ->will($this->returnValue('X'));

        $this->grid->play(new ColumnRowId('a', 1), $this->player);

        foreach ($this->grid as $cellId => $cell) {
            if ($cellId == 'a,1') {
                $this->assertEquals('X', $cell);
            } else {
                $this->assertEquals('', $cell);
            }
        }
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
     * @dataProvider provideDataToDisplay
     */
    public function test_should_fill_in_the_display($method)
    {
        $this->display
            ->expects($this->once())
            ->method($method)
            ->with('');

        $this->grid->render($this->display);
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
        );
    }

    /**
     * @dataProvider provideHorizontalData
     *
     * @param $row
     */
    public function test_should_have_an_horizontal_line($row)
    {
        $this->player
            ->expects($this->exactly(3))
            ->method('getToken')
            ->will($this->returnValue('W'));

        $this->assertFalse($this->grid->hasLine());
        $this->grid->play(new ColumnRowId('a', $row), $this->player);
        $this->grid->play(new ColumnRowId('b', $row), $this->player);
        $this->grid->play(new ColumnRowId('c', $row), $this->player);
        $this->assertTrue($this->grid->hasLine());
    }

    public function provideHorizontalData()
    {
        return array(
            array(1),
            array(2),
            array(3),
        );
    }

    /**
     * @dataProvider provideVerticalData
     *
     * @param $col
     */
    public function test_should_have_a_vertical_line($col)
    {
        $this->player
            ->expects($this->exactly(3))
            ->method('getToken')
            ->will($this->returnValue('W'));

        $this->assertFalse($this->grid->hasLine());
        $this->grid->play(new ColumnRowId($col, 1), $this->player);
        $this->grid->play(new ColumnRowId($col, 2), $this->player);
        $this->grid->play(new ColumnRowId($col, 3), $this->player);
        $this->assertTrue($this->grid->hasLine());
    }

    public function provideVerticalData()
    {
        return array(
            array('a'),
            array('b'),
            array('c'),
        );
    }

    /**
     * @dataProvider provideDiagonalData
     *
     * @param ColumnRowId $cell1
     * @param ColumnRowId $cell2
     * @param ColumnRowId $cell3
     */
    public function test_should_have_a_diagonal_line(ColumnRowId $cell1, ColumnRowId $cell2, ColumnRowId $cell3)
    {
        $this->player
            ->expects($this->exactly(3))
            ->method('getToken')
            ->will($this->returnValue('W'));

        $this->assertFalse($this->grid->hasLine());
        $this->grid->play($cell1, $this->player);
        $this->grid->play($cell2, $this->player);
        $this->grid->play($cell3, $this->player);
        $this->assertTrue($this->grid->hasLine());
    }

    public function provideDiagonalData()
    {
        return array(
            array(new ColumnRowId('a', 1), new ColumnRowId('b', 2), new ColumnRowId('c', 3)),
            array(new ColumnRowId('a', 3), new ColumnRowId('b', 2), new ColumnRowId('c', 1)),
        );
    }

    /**
     * @expectedException        \RuntimeException
     * @expectedExceptionMessage The cell already has a token.
     */
    public function test_should_throw_exception_when_the_cell_is_already_filled()
    {
        $this->player
            ->expects($this->once())
            ->method('getToken')
            ->will($this->returnValue('W'));

        $this->grid->play(new ColumnRowId('a', 1), $this->player);
        $this->grid->play(new ColumnRowId('a', 1), $this->getMockPlayer());
    }

    /**
     * @dataProvider provideWinningCellsPosition
     */
    public function test_should_return_the_winning_token($cell1, $cell2, $cell3)
    {
        $this->player
            ->expects($this->exactly(3))
            ->method('getToken')
            ->will($this->returnValue('W'));

        $this->grid->play($cell1, $this->player);
        $this->grid->play($cell2, $this->player);
        $this->grid->play($cell3, $this->player);
        $this->assertSame('W', $this->grid->getWinningToken());
    }

    public function provideWinningCellsPosition()
    {
        return array(
            'Horizontal line 1' => array(new ColumnRowId('a', 1), new ColumnRowId('b', 1), new ColumnRowId('c', 1)),
            'Horizontal line 2' => array(new ColumnRowId('a', 2), new ColumnRowId('b', 2), new ColumnRowId('c', 2)),
            'Horizontal line 3' => array(new ColumnRowId('a', 3), new ColumnRowId('b', 3), new ColumnRowId('c', 3)),
            'Vertical line 1' => array(new ColumnRowId('a', 1), new ColumnRowId('a', 2), new ColumnRowId('a', 3)),
            'Vertical line 2' => array(new ColumnRowId('b', 1), new ColumnRowId('b', 2), new ColumnRowId('b', 3)),
            'Vertical line 3' => array(new ColumnRowId('c', 1), new ColumnRowId('c', 2), new ColumnRowId('c', 3)),
            'Diagonal line 1' => array(new ColumnRowId('a', 1), new ColumnRowId('b', 2), new ColumnRowId('c', 3)),
            'Diagonal line 2' => array(new ColumnRowId('c', 1), new ColumnRowId('b', 2), new ColumnRowId('a', 3)),
        );
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockPlayer()
    {
        return $this->getMockBuilder(Player::CLASS_NAME)->disableOriginalConstructor()->getMock();
    }
}
 