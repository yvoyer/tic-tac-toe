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
 * @covers Star\TicTacToe\Grid\ColumnRowGrid
 * @covers Star\TicTacToe\Grid\CellGrid
 * @uses Star\TicTacToe\Id\ColumnRowId
 * @uses Star\TicTacToe\Grid\CellGrid
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
            array('setNorthWestCell'),
            array('setWestCell'),
            array('setSouthWestCell'),
            array('setNorthCell'),
            array('setCenterCell'),
            array('setSouthCell'),
            array('setNorthEastCell'),
            array('setEastCell'),
            array('setSouthEastCell'),
        );
    }

    /**
     * @dataProvider provideWinningCellsPosition
     *
     * @param \Star\TicTacToe\Id\CellId $cell1
     * @param \Star\TicTacToe\Id\CellId $cell2
     * @param \Star\TicTacToe\Id\CellId $cell3
     */
    public function test_should_have_a_winning_line(CellId $cell1, CellId $cell2, CellId $cell3)
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

    public function test_should_not_have_any_line()
    {
        $player1 = $this->getMockPlayer();
        $player1
            ->expects($this->any())
            ->method('getToken')
            ->will($this->returnValue('C'));

        $player2 = $this->getMockPlayer();
        $player2
            ->expects($this->any())
            ->method('getToken')
            ->will($this->returnValue('E'));

        $this->grid->play(new ColumnRowId('a', 1), $player1);
        $this->grid->play(new ColumnRowId('c', 1), $player1);
        $this->grid->play(new ColumnRowId('b', 2), $player1);
        $this->grid->play(new ColumnRowId('b', 3), $player1);
        $this->grid->play(new ColumnRowId('b', 1), $player2);
        $this->grid->play(new ColumnRowId('a', 2), $player2);
        $this->grid->play(new ColumnRowId('c', 2), $player2);
        $this->grid->play(new ColumnRowId('a', 3), $player2);
        $this->grid->play(new ColumnRowId('c', 3), $player2);
        $this->assertFalse($this->grid->hasLine());
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

    public function test_should_return_the_default_winning_token()
    {
        $this->assertSame('', $this->grid->getWinningToken());
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

    public function test_should_create_the_id()
    {
        $this->assertInstanceOf(ColumnRowId::INTERFACE_NAME, $this->grid->createId('a,1'));
    }

    /**
     * @param $string
     *
     * @dataProvider provideInvalidId
     *
     * @expectedException        \InvalidArgumentException
     * @expectedExceptionMessage The id must be of format X,Y.
     */
    public function test_should_throw_exception_when_invalid_arguments_given($string)
    {
        $this->grid->createId($string);
    }

    public function test_should_be_full()
    {
        $this->player
            ->expects($this->any())
            ->method('getToken')
            ->will($this->returnValue('E'));

        $this->assertFalse($this->grid->isFull());
        $this->grid->play($this->grid->createId('a,1'), $this->player);
        $this->assertFalse($this->grid->isFull());
        $this->grid->play($this->grid->createId('a,2'), $this->player);
        $this->assertFalse($this->grid->isFull());
        $this->grid->play($this->grid->createId('a,3'), $this->player);
        $this->assertFalse($this->grid->isFull());
        $this->grid->play($this->grid->createId('b,1'), $this->player);
        $this->assertFalse($this->grid->isFull());
        $this->grid->play($this->grid->createId('b,2'), $this->player);
        $this->assertFalse($this->grid->isFull());
        $this->grid->play($this->grid->createId('b,3'), $this->player);
        $this->assertFalse($this->grid->isFull());
        $this->grid->play($this->grid->createId('c,1'), $this->player);
        $this->assertFalse($this->grid->isFull());
        $this->grid->play($this->grid->createId('c,2'), $this->player);
        $this->assertFalse($this->grid->isFull());
        $this->grid->play($this->grid->createId('c,3'), $this->player);
        $this->assertTrue($this->grid->isFull());
    }

    public function provideInvalidId()
    {
        return array(
            array('1,2'),
            array('1'),
            array('a'),
            array('f,2'),
            array('wqed'),
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
 