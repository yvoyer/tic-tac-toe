<?php
/**
 * This file is part of the tic-tac-toe project.
 * 
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\TicTacToe\Display;

use Symfony\Component\Console\Output\BufferedOutput;

/**
 * Class ConsoleDisplayTest
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\TicTacToe\Display
 */
class ConsoleDisplayTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ConsoleDisplay
     */
    private $display;

    /**
     * @var BufferedOutput
     */
    private $output;

    public function setUp()
    {
        $this->output = new BufferedOutput();
        $this->display = new ConsoleDisplay($this->output);
    }

    public function test_should_render_the_grid()
    {
        $this->display->setNorthWestCell('NW');
        $this->display->setWestCell('W');
        $this->display->setSouthWestCell('SW');
        $this->display->setNorthCell('N');
        $this->display->setCenterCell('C');
        $this->display->setSouthCell('S');
        $this->display->setNorthEastCell('NE');
        $this->display->setEastCell('E');
        $this->display->setSouthEastCell('SE');
        $this->display->render();

        $content = $this->output->fetch();

        $result = <<<RESULT
 NW | N | NE
-----------
 W | C | E
-----------
 SW | S | SE

RESULT;

        $this->assertEquals($result, $content);
    }
}
 