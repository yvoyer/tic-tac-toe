<?php
/**
 * This file is part of the tic-tac-toe project.
 * 
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\TicTacToe;

/**
 * Class PlayerTest
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\TicTacToe
 */
class PlayerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Player
     */
    private $player;

    public function setUp()
    {
        $this->player = new Player('F', 'name');
    }

    public function test_should_return_the_token()
    {
        $this->assertSame('F', $this->player->getToken());
    }

    public function test_should_return_false_when_player_is_different()
    {
        $this->assertFalse($this->player->equals($this->getMockBuilder(Player::CLASS_NAME)->disableOriginalConstructor()->getMock()));
    }

    public function test_should_return_true_when_player_is_equals()
    {
        $this->assertTrue($this->player->equals($this->player));
    }

    public function test_should_have_a_name()
    {
        $this->assertSame('name', $this->player->getName());
    }
}
 