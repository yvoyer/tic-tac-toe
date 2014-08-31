<?php
/**
 * This file is part of the tic-tac-toe project.
 * 
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\TicTacToe\Grid;

use Star\TicTacToe\Id\CellId;
use Star\TicTacToe\Id\NumberId;
use Star\TicTacToe\Player;
use Star\TicTacToe\Display\TesterDisplay;

/**
 * Class NumberGridTest
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\TicTacToe\Grid
 *
 * @covers Star\TicTacToe\Grid\NumberGrid
 * @covers Star\TicTacToe\Grid\CellGrid
 * @uses Star\TicTacToe\Id\NumberId
 * @uses Star\TicTacToe\Display\TesterDisplay
 */
class NumberGridTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var NumberGrid
     */
    private $grid;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $player;

    public function setUp()
    {
        $this->player = $this->getMockBuilder(Player::CLASS_NAME)->disableOriginalConstructor()->getMock();
        $this->grid = new NumberGrid();
    }

    /**
     * @param $value
     *
     * @dataProvider provideValidValue
     *
     * @covers Star\TicTacToe\Id\NumberId
     */
    public function test_should_return_the_id($value)
    {
        $id = $this->grid->createId($value);
        $this->assertInstanceOf(CellId::INTERFACE_NAME, $id);
        $this->assertInstanceOf(NumberId::CLASS_NAME, $id);
        $this->assertSame((int) $value, $id->getValue());
    }

    public function provideValidValue()
    {
        return array(
            'Should support int 1' => array(1),
            'Should support int 2' => array(2),
            'Should support int 3' => array(3),
            'Should support int 4' => array(4),
            'Should support int 5' => array(5),
            'Should support int 6 ' => array(6),
            'Should support int 7' => array(7),
            'Should support int 8' => array(8),
            'Should support int 9' => array(9),
            'Should support string int' => array('3'),
        );
    }

    /**
     * @param $value
     *
     * @dataProvider provideInvalidValue
     *
     * @expectedException        \InvalidArgumentException
     * @expectedExceptionMessage Value must be int between 1-9.
     *
     * @covers Star\TicTacToe\Id\NumberId
     */
    public function test_should_throw_exception_when_invalid_value($value)
    {
        $this->grid->createId($value);
    }

    public function provideInvalidValue()
    {
        return array(
            'Should support lower than 1' => array(0),
            'Should support greater than 9' => array(10),
            'Should not support array' => array(array()),
            'Should not support float' => array(3.2),
            'Should not support string' => array('qwer'),
            'Should not support bool' => array(true),
        );
    }

    /**
     * @param $idValue
     * @param $method
     *
     * @dataProvider provideCellMapping
     */
    public function test_should_play_the_token($idValue, $method)
    {
        $this->player
            ->expects($this->any())
            ->method('getToken')
            ->will($this->returnValue('W'));

        $this->grid->play($this->grid->createId($idValue), $this->player);
        $tester = new TesterDisplay();
        $this->grid->render($tester);

        $getter = 'get' . ucfirst($method);
        $this->assertSame('W', $tester->{$getter}());
    }

    public function provideCellMapping()
    {
        return array(
            'Should play the NW cell' => array(1, 'northWest'),
            'Should play the N cell' => array(2, 'north'),
            'Should play the NE cell' => array(3, 'northEast'),
            'Should play the W cell' => array(4, 'west'),
            'Should play the C cell' => array(5, 'center'),
            'Should play the E cell' => array(6, 'east'),
            'Should play the SW cell' => array(7, 'southWest'),
            'Should play the S cell' => array(8, 'south'),
            'Should play the SE cell' => array(9, 'southEast'),
        );
    }
}
 