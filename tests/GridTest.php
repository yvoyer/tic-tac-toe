<?php
/**
 * This file is part of the tic-tac-toe project.
 * 
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\TicTacToe;

/**
 * Class GridTest
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\TicTacToe
 */
class GridTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Grid
     */
    private $grid;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $player;

    public function setUp()
    {
        $this->player = $this->getMockPlayer();

        $this->grid = new Grid();
    }

    public function test_should_put_the_player_token_on_cell()
    {
        $this->player
            ->expects($this->once())
            ->method('getToken')
            ->will($this->returnValue('X'));

        $this->grid->play(new CellId('a', 1), $this->player);

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
        $this->grid->play(new CellId('r', 4), $this->player);
    }

    /**
     * @dataProvider provideDataToDisplay
     */
    public function test_should_fill_in_the_display($method)
    {
        $display = $this->getMock('Star\TicTacToe\Display');
        $display
            ->expects($this->once())
            ->method($method)
            ->with('');

        $this->grid->render($display);
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
        $this->grid->play(new CellId('a', $row), $this->player);
        $this->grid->play(new CellId('b', $row), $this->player);
        $this->grid->play(new CellId('c', $row), $this->player);
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
        $this->grid->play(new CellId($col, 1), $this->player);
        $this->grid->play(new CellId($col, 2), $this->player);
        $this->grid->play(new CellId($col, 3), $this->player);
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
     * @param CellId $cell1
     * @param CellId $cell2
     * @param CellId $cell3
     */
    public function test_should_have_a_Diagonal_line(CellId $cell1, CellId $cell2, CellId $cell3)
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
            array(new CellId('a', 1), new CellId('b', 2), new CellId('c', 3)),
            array(new CellId('a', 3), new CellId('b', 2), new CellId('c', 1)),
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

        $this->grid->play(new CellId('a', 1), $this->player);
        $this->grid->play(new CellId('a', 1), $this->getMockPlayer());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockPlayer()
    {
        return $this->getMockBuilder(Player::CLASS_NAME)->disableOriginalConstructor()->getMock();
    }
}
 