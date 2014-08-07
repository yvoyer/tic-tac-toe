<?php
/**
 * This file is part of the tic-tac-toe project.
 * 
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\TicTacToe;

/**
 * Class CellIdTest
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\TicTacToe
 */
class CellIdTest extends \PHPUnit_Framework_TestCase
{
    public function test_should_return_the_cell_id_as_a_string()
    {
        $id = new CellId('d', 2);
        $this->assertSame('d,2', (string) $id);
    }

    public function test_should_return_the_cell_id_as_a_lower_case_string()
    {
        $id = new CellId('D', 2);
        $this->assertSame('d,2', (string) $id);
    }
}
 