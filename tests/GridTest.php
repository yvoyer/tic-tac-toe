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

    public function setUp()
    {
        $this->grid = new Grid();
    }

    public function test_should_put_the_player_token_on_cell()
    {
        $player = $this->getMockPlayer();
        $player
            ->expects($this->once())
            ->method('getToken')
            ->will($this->returnValue('X'));

        $this->grid->play(new CellId('a', 1), $player);

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
        $this->grid->play(new CellId('r', 4), $this->getMockPlayer());
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
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockPlayer()
    {
        return $this->getMockBuilder(Player::CLASS_NAME)->disableOriginalConstructor()->getMock();
    }
}
 