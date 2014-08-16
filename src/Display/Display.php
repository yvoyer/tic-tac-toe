<?php
/**
 * This file is part of the tic-tac-toe project.
 * 
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\TicTacToe\Display;

/**
 * Class Display
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\TicTacToe\Display
 */
interface Display
{
    public function setA1($token);
    public function setA2($token);
    public function setA3($token);
    public function setB1($token);
    public function setB2($token);
    public function setB3($token);
    public function setC1($token);
    public function setC2($token);
    public function setC3($token);
    public function render();
}
 